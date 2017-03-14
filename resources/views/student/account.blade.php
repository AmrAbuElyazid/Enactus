@extends('student.layout.app')
@section('content')
<div class="container" ng-controller="StudentAccountController" class="md-padding" ng-cloak>
<md-progress-linear md-mode="indeterminate" ng-if="progress"></md-progress-linear>
	<div class="row">
	<label for="photo" class="custom-file-upload"><img ng-src="@{{ student.photo }}" alt="" style="position: relative; border: 3px solid #3F51B5; margin-bottom: 75px; margin-left: -100px; left: 50%;  width: 150px; height: 150px; border-radius: 50%;"></label>
	<input id="photo" type="file" ng-model="student.photo" style="display: none;" base-sixty-four-input>
		<div class="settings">
			<md-content layout-padding>
			<form name="StudentForm">
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>First Name</label>
					<input md-maxlength="30" required md-no-asterisk name="first_name" ng-model="student.first_name">
					<div ng-messages="StudentForm.first_name.$error">
						<div ng-message="required">This is required.</div>
						<div ng-message="md-maxlength">Name must be less than 30 characters long.</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>Last Name</label>
					<input md-maxlength="30" required md-no-asterisk name="last_name" ng-model="student.last_name">
					<div ng-messages="StudentForm.last_name.$error">
						<div ng-message="required">This is required.</div>
						<div ng-message="md-maxlength">Name must be less than 30 characters long.</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>Email</label>
					<input required type="email" name="email" ng-model="student.email"
					minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/" />
					<div ng-messages="StudentForm.email.$error" role="alert">
						<div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
							Your email must be between 10 and 100 characters long and look like an e-mail address.
						</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Phone Number</label>
					<input name="phone_number" ng-model="student.phone_number" ng-pattern="/\d{11}/" />
					<div ng-messages="StudentForm.phone_number.$error" role="alert">
						<div ng-message="pattern">01234567891 - Please enter a valid phone number.</div>
					</div>
					</md-input-container>
				</div>
				
				<div class="col-md-6">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Address</label>
					<input md-maxlength="200" required name="address" ng-model="student.address" />
					<div class="hint" ng-if="showHints">Tell us what is your address!</div>
					<div ng-messages="StudentForm.address.$error" ng-if="!showHints">
						<div ng-message="required">Address is requireed</div>
						<div ng-message="md-maxlength">The name has to be less than 200 characters long.</div>
					</div>
					</md-input-container>
				</div>
				

				<div class="col-md-6">
						<br>
						      <md-datepicker ng-model="student.date_of_birth" md-placeholder="Enter date" md-open-on-focus></md-datepicker>
					<label style="margin-left: 62px;">Date Of Birth</label>
				</div>
				
				<div class="col-md-12">
					<md-button class="md-raised md-primary" ng-click="updateAccountSettings()" style="position:relative; left:45%;">Save</md-button>
				</div>
			</form>
			</md-content>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="/js/angular-image-base64.js"></script>
<script src="/js/controllers/student/StudentAccountController.js"></script>
@endsection