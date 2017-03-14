@extends('teacher.layout.app')
@section('content')
<div class="container" ng-controller="TeacherAccountController" id="container">
<md-progress-linear md-mode="indeterminate" ng-if="progress"></md-progress-linear>

	<label for="photo" class="custom-file-upload"><img ng-src="@{{ teacher.photo }}" alt="" style="position: relative; border: 3px solid #3F51B5; margin-bottom: 30px; margin-left: -100px; left: 50%;  width: 150px; height: 150px; border-radius: 50%;"></label>
	<input id="photo" type="file" ng-model="teacher.photo" style="display: none;" base-sixty-four-input>
	<div class="row">
		<div class="settings">
			<md-content layout-padding>
			<form name="TeacherForm">
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>First Name</label>
					<input md-maxlength="30" required md-no-asterisk name="first_name" ng-model="teacher.first_name">
					<div ng-messages="TeacherForm.first_name.$error">
						<div ng-message="required">This is required.</div>
						<div ng-message="md-maxlength">Name must be less than 30 characters long.</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>Last Name</label>
					<input md-maxlength="30" required md-no-asterisk name="last_name" ng-model="teacher.last_name">
					<div ng-messages="TeacherForm.last_name.$error">
						<div ng-message="required">This is required.</div>
						<div ng-message="md-maxlength">Name must be less than 30 characters long.</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block">
					<label>Email</label>
					<input required type="email" name="email" ng-model="teacher.email"
					minlength="10" maxlength="100" ng-pattern="/^.+@.+\..+$/" />
					<div ng-messages="TeacherForm.email.$error" role="alert">
						<div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
							Your email must be between 10 and 100 characters long and look like an e-mail address.
						</div>
					</div>
					</md-input-container>
				</div>
				<div class="col-md-6">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Phone Number</label>
					<input name="phone_number" ng-model="teacher.phone_number" ng-pattern="/\d{11}/" />
					<div ng-messages="TeacherForm.phone_number.$error" role="alert">
						<div ng-message="pattern">01234567891 - Please enter a valid phone number.</div>
					</div>
					</md-input-container>
				</div>
				
				<div class="col-md-6">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Address</label>
					<input md-maxlength="200" required name="address" ng-model="teacher.address" />
					<div ng-messages="TeacherForm.address.$error" ng-if="!showHints">
						<div ng-message="required">Address is requireed</div>
						<div ng-message="md-maxlength">The name has to be less than 200 characters long.</div>
					</div>
					</md-input-container>
				</div>
				
				
				<div class="col-md-6">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Talent</label>
					<input md-maxlength="50" required name="talent" ng-model="teacher.talent" />
					<div ng-messages="TeacherForm.talent.$error" ng-if="!showHints">
						<div ng-message="required">Interests is requireed</div>
						<div ng-message="md-maxlength">The name has to be less than 50 characters long.</div>
					</div>
					</md-input-container>
				</div>
				
				<div class="col-md-6">
					<md-input-container">
					<label>Proficiency</label>
					<md-select name="proficiency" ng-model="teacher.proficiency" required>
					<md-option value="beginner">beginner</md-option>
					<md-option value="intermediate">intermediate</md-option>
					<md-option value="expert">expert</md-option>
					</md-select>
					<div class="errors" ng-messages="myForm.proficiency.$error">
						<div ng-message="required">Required</div>
					</div>
					</md-input-container>
				</div>

				<div class="col-md-6">
					<br>
					<md-input-container>
					<md-datepicker ng-model="teacher.date_of_birth" md-placeholder="Enter date" md-open-on-focus></md-datepicker>
					<label>Date Of Birth</label>
					</md-input-container>
				</div> 

				<div class="col-md-12">
					<md-input-container class="md-block" flex-gt-sm>
					<label>Interests</label>
					<textarea md-maxlength="200" required name="interests" ng-model="teacher.interests" >
					</textarea>
					<div ng-messages="TeacherForm.interests.$error" ng-if="!showHints">
						<div ng-message="required">Interests is requireed</div>
						<div ng-message="md-maxlength">The name has to be less than 200 characters long.</div>
					</div>
					</md-input-container>
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
<script src="/js/controllers/teacher/TeacherAccountController.js"></script>
@endsection