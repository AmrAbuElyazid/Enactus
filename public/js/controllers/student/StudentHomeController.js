var app = angular.module('app', ['ngMaterial', 'ngMessages']);
app.controller('StudentHomeController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
    /**
     * Teachers OBJ
     * @type {OGB}
     */
    $scope.teachers = null;

    (function () {
        $http({
            method: 'GET',
            url: '/student/get/match/teachers'
        }).then(function success(response) {
            $scope.teachers = response.data.teachers

        	$scope.currentPage = 0;
		    $scope.pageSize = 20;

            $scope.numberOfPages=function(){
		        return Math.ceil($scope.teachers.length/$scope.pageSize);                
		    }

        });
        $http({
        	method: 'GET',
        	url: '/student/teachers/count',
        }).then(function success(response) {
        	$scope.teachersCount = response.data.teachersCount
        	$scope.studentsCount = response.data.studentsCount
        });
    })();

    $scope.showDate = function ($id) {
        $http({
            method: 'GET',
            url: 'get/teacher/' + $id,
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

    $scope.sendFriendRequestToTeacher = function (id) {
    	$http({
    		method: 'POST',
    		url: '/student/send/toTeacher/' + id,
    	}).then(function success(response) {
    		$mdDialog.show(
			$mdDialog.alert()
				.parent(angular.element(document.querySelector('.container')))
				.clickOutsideToClose(true)
				.title('Suceess')
				.textContent('Friend Requst Send Successfully')
				.ariaLabel('Alert Dialog Demo')
				.ok('Close')
				.targetEvent()
			);
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