var app = angular.module('app', ['ngMaterial', 'ngMessages', 'ngRateIt']);
app.controller('StudentTeacherController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {
    $scope.teacher = {
        first_name: null,
        last_name: null,
        photo: null,
        email: null,
        address: null,
        date_of_birth: null,
        interests: null,
    };

    $scope.showRemoveButton = false;
    $scope.showAddFriendButton = false;
    $scope.showPendingRedeemButton = false;

    $scope.rate = 0;

    $scope.getTeacherRate = function () {
        $http({
            method: 'GET',
            url: '/student/rate/' + $scope.teacher_id,
        }).then(function success(response) {
            $scope.rate = response.data.rate
        });
    };

    $scope.rated = function () {
        $http({
            method: 'POST',
            url: '/student/rate',
            data: {
                rate: $scope.rate,
                teacher_id: $scope.teacher_id,
            },
        }).then(function success(response) {
            $scope.rate = response.data.rate

            $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('.container')))
                .clickOutsideToClose(true)
                .title('Success')
                .textContent('Thanks for rating')
                .ariaLabel('Alert Dialog Rate')
                .ok('Close')
                .targetEvent()
            );
        });
    };

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
                $scope.showAddFriendButton = true;

                $mdDialog.show(
                    $mdDialog.alert()
                        .parent(angular.element(document.querySelector('.container')))
                        .clickOutsideToClose(true)
                        .title('Friend Removed!')
                        .textContent(name + ' Is removed from your friend\'s list')
                        .ariaLabel('Alert Message sent')
                        .ok('OK')
                );
            });
        });
    }

    $scope.sendFriendRequestToTeacher = function (id) {
        $http({
            method: 'POST',
            url: '/student/send/toTeacher/' + id,
        }).then(function success(response) {
            $scope.isFriendRequestSent = true;
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

}]);
