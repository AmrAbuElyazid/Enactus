var app = angular.module('app', ['ngMaterial']);
app.controller('StudentMessageController', ['$scope', '$http', '$mdDialog', function($scope, $http, $mdDialog, $mdSidenav) {
    $scope.messages = [];
    $scope.message = null;

    $scope.getTeacherMessages = function () {
        $http({
            method: 'GET',
            url: '/student/get/messages/' + $scope.teacher_id
        }).then(function success(response) {
            for (var i = 1; i <= response.data.messages.length; i++) {
                if (response.data.messages[i-1].sender_type == 'App\\Student') {
                    $scope.messages.push({
                        message: response.data.messages[i-1].message,
                        direction: 'to',
                    });
                }

                if (response.data.messages[i-1].sender_type == 'App\\Teacher') {
                    $scope.messages.push({
                        message: response.data.messages[i-1].message,
                        direction: 'from',
                    });
                }
            }
            var elem = document.getElementById('messagesWrapper');
            elem.scrollTop = elem.scrollHeight;
        });
    }

    $scope.getUnreadedMessages = function () {
        $http({
            method: 'GET',
            url: '/student/message/unreaded/' + $scope.teacher_id,
        }).then(function success(response) {
            for (var i = 1; i <= response.data.messages.length; i++) {
                $scope.messages.push({
                    message: response.data.messages[i-1].message,
                    direction: 'from',
                });
            }

            $http({
                method: 'GET',
                url: '/student/message/unread/' + $scope.teacher_id,
            });
        });
    }

    window.setInterval(function() {
        $scope.getUnreadedMessages();
    }, 2000);

    $scope.sendMessage = function () {
        if ($scope.message != null && $scope.message != '') {
            $http({
                method: 'POST',
                url: '/student/message/' + $scope.teacher_id,
                data: {
                    teacher_id: $scope.teacher_id,
                    message: $scope.message,
                }
            }).then(function success(response) {
                $scope.messages.push({
                    message: $scope.message,
                    direction: 'to',
                });
                $scope.message = null;
                elem = document.getElementById('messagesWrapper');
                elem.scrollTop = elem.scrollHeight;
            });
        }
    };
}]);

app.filter('reverse', function() {
  return function(items) {
    return items.slice().reverse();
  };
});