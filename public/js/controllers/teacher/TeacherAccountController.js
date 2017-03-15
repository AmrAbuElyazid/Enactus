var app = angular.module('app', ['ngMaterial', 'ngMessages', 'ngAria', 'naif.base64']);
app.controller('TeacherAccountController', ['$scope', '$http', '$mdDialog', '$mdSidenav', function ($scope, $http, $mdDialog, $mdSidenav) {
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

	$scope.teacher = {
		first_name: null,
		last_name: null,
		email: null,
		phone_number: null,
		photo: null,
		date_of_birth: null,
		address: null,
		interests: [],
		talent: null,
		proficiency: null,
		comment: null,
	};

	/**
	 * Get Teacher Account Settings
	 */
	(function () {
		$http({
			method: 'GET',
			url: '/teacher/settings/get',
		}).then(function success(response) {
			// console.log(formatMysqlDate(response.data.teacher.date_of_birth));
			$scope.teacher.first_name = response.data.teacher.first_name
			$scope.teacher.last_name = response.data.teacher.last_name
			$scope.teacher.email = response.data.teacher.email
			$scope.teacher.phone_number = response.data.teacher.phone_number
			if (response.data.teacher.interests !== null) {
				$scope.teacher.interests = Object.values(JSON.parse(response.data.teacher.interests))
			}
			$scope.teacher.photo = response.data.teacher.photo
			$scope.teacher.address = response.data.teacher.address
			$scope.teacher.talent = response.data.teacher.talent
			$scope.teacher.proficiency = response.data.teacher.proficiency
			$scope.teacher.comment = response.data.teacher.comment
			$scope.teacher.date_of_birth = formatMysqlDate(response.data.teacher.date_of_birth)
		}, function error(response) {

		});
	})();


	/**
     * Update teacher Account Settingd
     * @return {json}
     */
    $scope.updateAccountSettings = function() {
        $scope.progress = true;
        var date = new Date(new Date($scope.teacher.date_of_birth).getTime());

        $http({
            method: 'PATCH',
            url: '/teacher/settings/update',
            data: {
                first_name: $scope.teacher.first_name,
                last_name: $scope.teacher.last_name,
                email: $scope.teacher.email,
                phone_number: $scope.teacher.phone_number,
                photo: $scope.teacher.photo,
                address: $scope.teacher.address,
                interests: $scope.teacher.interests,
                talent: $scope.teacher.talent,
                proficiency: $scope.teacher.proficiency,
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

		var temp = myDate[1];
		myDate[1] = myDate[2];
		myDate[2] = temp;

		return new Date(myDate.join('-'));
 	}
}]);