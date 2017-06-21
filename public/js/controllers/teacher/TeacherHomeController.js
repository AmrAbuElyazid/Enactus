var app = angular.module('app', ['ngMaterial', 'ngMessages']);
app.controller('TeacherHomeController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
    /**
     * Teachers OBJ
     * @type {OBJ}
     */
    $scope.students = null;

    (function () {
        $http({
            method: 'GET',
            url: '/teacher/get/match/students'
        }).then(function success(response) {
            $scope.students = response.data.students

        	$scope.currentPage = 0;
		    $scope.pageSize = 20;
            $scope.numberOfPages=function(){
		        return Math.ceil($scope.students.length/$scope.pageSize);                
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
            url: 'get/student/' + $id,
        }).then(function success(response) {
            $mdDialog.show({
                controller: DialogController,
                templateUrl: '/js/templates/student.tmpl.html',
                clickOutsideToClose:true,
				fullscreen: $scope.customFullscreen,
                locals: {
                    student: response.data.student,
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
    		url: '/teacher/send/toStudent/' + id,
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


    function DialogController($scope, $mdDialog, student, pendingFriendRequest, isFriend) {
        $scope.student = student
        $scope.pendingFriendRequest = pendingFriendRequest
        $scope.isFriend = isFriend

        $scope.sendStudentId = function(id) {
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