app.controller('AccountController', ['$scope', '$http', function($scope, $http) {
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