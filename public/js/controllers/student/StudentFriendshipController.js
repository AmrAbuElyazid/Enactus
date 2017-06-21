var app = angular.module('app', ['ngMaterial', 'ngMessages']);

app.controller('StudentFriendshipController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
	$scope.friends = null;
	$scope.pendingReqests = [];

	(function () {
		$http({
			method: 'GET',
			url: '/student/get/friends'
		}).then(function success(response) {
			$scope.friends = response.data.friends;

			$scope.currentPage = 0;
		    $scope.pageSize = 24;
            $scope.numberOfPages=function(){
		        return Math.ceil($scope.friends.length/$scope.pageSize);                
		    }
		});
	})();

	$scope.getPendingRequests = function () {
		$http({
			method: 'GET',
			url: '/student/get/pending'
		}).then(function success(response) {
			response.data.friends.map(function (friend) {
				if (friend.studentHasPendingFriendRequest == true) {
					$scope.pendingReqests.push(friend);
				}
			});
		})
	}

	$scope.sendMessageToTeacher = function (id) {
		var confirm = $mdDialog.prompt()
			.title('Message')
			.textContent('What is your message, Write Your message')
			.placeholder('Message')
			.ariaLabel('Message')
			.initialValue('Hi')
			.ok('Send')
			.cancel('Cancel');

		$mdDialog.show(confirm).then(function(message) {
			$http({
				method: 'POST',
				url: '/student/message/' + id,
				data: {
					message: message
				}
			}).then(function success(response) {
				$mdDialog.show(
					$mdDialog.alert()
						.parent(angular.element(document.querySelector('.container')))
						.clickOutsideToClose(true)
						.title('Success')
						.textContent('Message sent successfully.')
						.ariaLabel('Alert Message sent')
						.ok('OK')
				);
			});
		});
	}

	$scope.showDate = function (id) {
        $http({
            method: 'GET',
            url: '/student/get/teacher/' + id,
        }).then(function success(response) {
            $mdDialog.show({
                controller: DialogController,
                templateUrl: '/js/templates/teacher.tmpl.html',
                clickOutsideToClose:true,
				fullscreen: $scope.customFullscreen,
                locals: {
                    teacher: response.data.teacher,
                    pendingFriendRequest: response.data.pendingFriendRequest,
                    isFriend: response.data.isFriend
                }
            }).then(function (id) {
            	$scope.sendFriendRequestToTeacher(id);
            });
        }, function error(response) {

        });
    }

    $scope.removeFriend = function (id, name) {
    	var confirm = $mdDialog.confirm()
			.title('Would you like to delete your friend?')
			.textContent('You will delete ' + name + ' are you sure!')
			.ariaLabel('Delete Friend')
			.ok('Yes')
			.cancel('Cancel');

	    $mdDialog.show(confirm).then(function() {
			$http({
				method: 'POST',
				url: '/student/delete/' + id
			}).then(function success(response) {
				$mdDialog.show(
					$mdDialog.alert()
						.parent(angular.element(document.querySelector('.container')))
						.clickOutsideToClose(true)
						.title('Friend Removed!')
						.textContent(name + ' Is removed from your friend\'s list')
						.ariaLabel('Alert Message sent')
						.ok('OK')
				);

				(function () {
					$http({
						method: 'GET',
						url: '/student/get/friends'
					}).then(function success(response) {
						$scope.friends = response.data.friends;

						$scope.currentPage = 0;
					    $scope.pageSize = 24;
			            $scope.numberOfPages=function(){
					        return Math.ceil($scope.friends.length/$scope.pageSize);                
					    }
					});
				})();
			});
	    });
    }

    $scope.acceptFriendRequest = function (id, request) {
    	$http({
    		method: 'POST',
    		url: '/student/accept/teacher/' + id,
    	}).then(function success(response) {
    		
    		var newItems = $scope.pendingReqests.filter(function (i){
				return request.id !== i.teacher.id;
			});
			$scope.pendingReqests = newItems;
    	});
    }


    function DialogController($scope, $mdDialog, teacher, pendingFriendRequest, isFriend) {
        $scope.teacher = teacher
        $scope.pendingFriendRequest = pendingFriendRequest
        $scope.isFriend = isFriend

        $scope.sendTeacherId = function(id) {
        	$mdDialog.hide(id);
        };

        $scope.cancel = function() {
          $mdDialog.cancel();
        };

        $scope.answer = function(answer) {
          $mdDialog.hide(id);
        };
	}
}]);

app.filter('startFrom', function() {
    return function(input, start) {
        if (!input || !input.length) { return; }
        start = +start; //parse to int
        return input.slice(start);
    }
});