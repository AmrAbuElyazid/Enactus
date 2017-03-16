var app = angular.module('app', ['ngMaterial', 'ngMessages']);
app.controller('StudentHomeController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
    /**
     * Teachers OBJ
     * @type {OGB}
     */
    $scope.teachers = null;
        	$scope.currentPage = 0;
		    $scope.pageSize = 10;

    (function () {
        $http({
            method: 'GET',
            url: '/student/get/match/teachers'
        }).then(function success(response) {
            $scope.teachers = response.data.teachers
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
            console.log(response.data)
            $mdDialog.show({
                controller: DialogController,
                templateUrl: '/js/templates/teacher.tmpl.html',
                clickOutsideToClose:true,
				fullscreen: $scope.customFullscreen,
                locals: {
                    teacher: response.data
                }
            });
        }, function error(response) {

        });
    }


    function DialogController($scope, $mdDialog, teacher) {
        $scope.teacher = teacher
        ;
        $scope.hide = function() {
          $mdDialog.hide();
        };

        $scope.cancel = function() {
          $mdDialog.cancel();
        };

        $scope.answer = function(answer) {
          $mdDialog.hide(answer);
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