var app = angular.module('app', ['ngMaterial', 'ngMessages']);
app.controller('StudentTeacherController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
    $scope.teacher = {
        first_name: null,
        last_name: null,
        photo: null,
        email: null,
        address: null,
        date_of_birth: null,
        interests: null,
    }
}]);