var app = angular.module('app', ['ngMaterial', 'ngMessages', 'ngRateIt']);
app.controller('TeacherStudentController', ['$scope', '$http', '$mdDialog', function ($scope, $http, $mdDialog) {


    $scope.showRemoveButton = false;
    $scope.showAddFriendButton = false;
    $scope.showPendingRedeemButton = false;

    $scope.review = null;
    $scope.rate = 0;

    $scope.getStudentRateAndReview = function () {
        $http({
            method: 'GET',
            url: '/teacher/rate/' + $scope.student_id,
        }).then(function success(response) {
            $scope.rate = response.data.rate
        });

        $http({
            method: 'GET',
            url: '/teacher/review/' + $scope.student_id,
        }).then(function success(response) {
            $scope.review = response.data.review 
        });
    };

    $scope.rated = function () {
        $http({
            method: 'POST',
            url: '/teacher/rate',
            data: {
                rate: $scope.rate,
                student_id: $scope.student_id,
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
                url: '/teacher/delete/' + id
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
            url: '/teacher/send/toStudent/' + id,
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
            location.reload();
        });
    }

    $scope.sendReview = function (student_id) {
        $http({
            method: 'POST',
            url: '/teacher/review',
            data: {
                student_id: student_id,
                review: $scope.review,
            }
        }).then(function success(response) {
            $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('.container')))
                .clickOutsideToClose(true)
                .title('Suceess')
                .textContent('Review Sent Successfully')
                .ariaLabel('Alert Dialog Demo')
                .ok('Close')
                .targetEvent()
            );
        });
    }

}]);
