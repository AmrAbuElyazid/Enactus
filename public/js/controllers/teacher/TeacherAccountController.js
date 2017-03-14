app.controller('TeacherAccountController', ['$scope', '$http', function ($scope, $http) {
	$scope.showHints = true;

	$scope.teacher = {
		first_name: null,
		last_name: null,
		email: null,
		phone_number: null,
		date_of_birth: null,
		address: null,
		interests: null,
		talent: null,
		// proficiecy: null,
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
			// console.log(formatMysqlDate(response.data.student.date_of_birth));
			$scope.teacher.first_name = response.data.student.first_name
			$scope.teacher.last_name = response.data.student.last_name
			$scope.teacher.email = response.data.student.email
			$scope.teacher.phone_number = response.data.student.phone_number
			$scope.teacher.address = response.data.student.address
			$scope.teacher.interests = response.data.student.interests
			$scope.teacher.talent = response.data.student.talent
			$scope.teacher.proficiency = response.data.student.proficiency
			$scope.teacher.comment = response.data.student.comment
			$scope.teacher.date_of_birth = formatMysqlDate(response.data.student.date_of_birth)
		}, function error(response) {

		});
	})();



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