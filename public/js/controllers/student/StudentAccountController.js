var app = angular.module('app', ['ngMaterial', 'ngMessages', 'ngAria', 'naif.base64']);
app.controller('StudentAccountController', ['$scope', '$http', '$mdDialog', '$mdSidenav', function($scope, $http, $mdDialog, $mdSidenav) {
    /**
     * Var to indicate progress
     * @type {Boolean}
     */
    $scope.progress = false;
    
    /**
     * Var to indicate suceess
     * @type {Boolean}
     */
    $scope.success = false;
    
    /**
     * student data
     * @type {Object}
     */
    $scope.student = {
        first_name: null,
        last_name: null,
        email: null,
        phone_number: null,
        interests: [],
        photo: null,
        address: null,
        date_of_birth: null,
    };

    /**
     * self-invoked function to load student data 
     */
    (function () {
        $http({
            method: 'GET',
            url: '/student/settings/get',
        }).then(function success(response) {
            $scope.student.first_name = response.data.student.first_name
            $scope.student.last_name = response.data.student.last_name
            $scope.student.email = response.data.student.email
            $scope.student.photo = response.data.student.photo
            $scope.student.phone_number = response.data.student.phone_number
            if (response.data.student.interests !== null) {
                $scope.student.interests = Object.values(JSON.parse(response.data.student.interests))            
            }
            $scope.student.address = response.data.student.address
            $scope.student.date_of_birth = formatMysqlDate(response.data.student.date_of_birth)

        }, function error(response) {
            console.log(response);
        });
    })();


    /**
     * Update Student Account Settingd
     * @return {json}
     */
    $scope.updateAccountSettings = function() {
        $scope.progress = true;
        var date = new Date(new Date($scope.student.date_of_birth).getTime());

        $http({
            method: 'PATCH',
            url: '/student/settings/update',
            data: {
                first_name: $scope.student.first_name,
                last_name: $scope.student.last_name,
                email: $scope.student.email,
                phone_number: $scope.student.phone_number,
                interests: $scope.student.interests,
                photo: $scope.student.photo,
                address: $scope.student.address,
                date_of_birth: date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2) + ' 00:00:00',
            }
        }).then(function success(response) {
            console.log('updated');
            $scope.progress = false;
    
            $scope.showAlert();

            }, function error() {
            console.log(response);
        });
    };

    $scope.showAlert = function() {
        $mdDialog.show(
          $mdDialog.alert()
            .parent(angular.element(document.querySelector('#container')))
            .clickOutsideToClose(true)
            .title('Suceess')
            .textContent('You update your settings successfully.')
            .ariaLabel('Alert Dialog Demo')
            .ok('Close')
            .targetEvent()
        );
    };

    /**
     * Format Date To show in html
     * @param  {mysql date} mySQLDate
     * @return {date}       date compitiable with html date <input>
     */
    function formatMysqlDate(mySQLDate)
    {
        new Date(Date.parse(mySQLDate.replace('-','/','g')));
        var myDate = mySQLDate.toString().slice(0, 10).split(/[- :]/);
        
        return new Date(myDate.join('-'));
    }
}]);