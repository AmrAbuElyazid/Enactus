@extends('teacher.layout.app')
@section('content')
<div class="container" ng-controller="TeacherAccountController">
	<div class="row">
		<div class="alert material-alert material-alert_success" ng-if="success">You successfully updated your account settings.</div>
		<div class="settings">
			<form>
				{{ csrf_field() }}
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<input type="text" name="first_name" ng-model="teacher.first_name" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>First Name</label>
						</div>
						<div class="col-md-6">
							<input type="text" name="last_name" ng-model="teacher.last_name" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Last Name</label>
						</div>
					</div>
				</div>
				
				<div class="group col-md-9 col-md-offset-1">
					<input type="email" name="email" ng-model="teacher.email" required>
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Email</label>
				</div>
				
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<input type="text" name="phone_number" ng-model="teacher.phone_number" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Phone Number</label>
							
						</div>
						<div class="col-md-6">
							<input type="text" name="address" ng-model="teacher.address" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Address</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<input type="Date" name="date_of_birth" ng-model="teacher.date_of_birth" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Date Of Birth</label>
						</div>
						<div class="col-md-6">
							<input type="input" name="talent" ng-model="teacher.talent" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Talent</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<select name="" id="" ng-model="teacher.proficiency">
								<option value="Beginner">beginner</option>
								<option value="Intermediate">intermediate</option>
								<option value="Expert">expert</option>
							</select>
						</div>
						<div class="col-md-6">
							<input type="input" name="talent" ng-model="teacher.talent" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Talent</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<textarea name="" id="" cols="30" rows="10" ng-model="teacher.comment"></textarea>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Talent</label>
						</div>
						<div class="col-md-6">
							<textarea name="" id="" cols="30" rows="10" ng-model="teacher.interests"></textarea>
						</div>
					</div>
				</div>
				<div class="col-md-5 col-md-offset-3">
					<button ng-click="updateAccountSettings()"> <span ng-if="!progress">Save</span>
					<svg class="spinner" ng-show="progress" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
						<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
					</svg>
					</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="/js/controllers/teacher/TeacherAccountController.js"></script>
@endsection