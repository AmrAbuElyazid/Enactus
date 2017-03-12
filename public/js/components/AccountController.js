app.controller('AccountController', ['$scope', '$http', function($scope, $http) {
	$scope.progress = false;
	$scope.success = null;

	$scope.student = {
		first_name: null,
		second_name: null,
		email: null,
		phone_number: null,
		address: null,
		date_of_birth: null,
	};

 	(function () {
 		$http({
 			method: 'GET',
 			url: '/student/settings/get',
 		}).then(function success(response) {
 			$scope.student.first_name = response.data.student.first_name
 			$scope.student.last_name = response.data.student.last_name
 			$scope.student.email = response.data.student.email
 			$scope.student.phone_number = response.data.student.phone_number
 			$scope.student.address = response.data.student.address
 			$scope.student.date_of_birth = formatDate(response.data.student.date_of_birth);

 		}, function error(response) {
 			console.log(response);
 		});
 	})();



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
 				address: $scope.student.address,
 				date_of_birth: date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2) + ' 00:00:00',
 			}
 		}).then(function success(response) {
 			console.log('updated');
 			$scope.progress = false;
 			$scope.success = true;
 		}, function error() {
 			console.log(response);
 		});
 	};



 	function formatDate(mySQLDate)
 	{
 		new Date(Date.parse(mySQLDate.replace('-','/','g')));
		var myDate = mySQLDate.toString().slice(0, 10).split(/[- :]/);

		var temp = myDate[1];
		myDate[1] = myDate[2];
		myDate[2] = temp;

		return new Date(myDate.join('-'));
 	}
}]);