@extends('student.layout.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="settings">
			<form action="{{ route('account.update') }}" method="POST">
				{{ method_field('patch') }}
				{{ csrf_field() }}

				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<input type="text" name="first_name" value="{{ $student->first_name }}" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>First Name</label>
							
						</div>
						<div class="col-md-6">
							<input type="text" name="last_name" value="{{ $student->last_name }}" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Last Name</label>
						</div>
					</div>
				</div>
				
				
				<div class="group col-md-9 col-md-offset-1">
					<input type="email" name="email" value="{{ $student->email }}" required>
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Email</label>
				</div>
				
				<div class="row">
					<div class="group col-md-9 col-md-offset-1">
						<div class="col-md-6">
							<input type="text" name="phone_number" value="{{ $student->phone_number }}" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Phone Number</label>
							
						</div>
						<div class="col-md-6">
							<input type="text" name="address" value="{{ $student->address }}" required>
							<span class="highlight"></span>
							<span class="bar"></span>
							<label>Address</label>
						</div>
					</div>
				</div>
				<div class="group col-md-9 col-md-offset-1">
					<input type="Date" name="date_of_birth" value="{{ Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d') }}" required>
					<span class="highlight"></span>
					<span class="bar"></span>
					<label>Date Of Birth</label>
				</div>
				
				<div class="col-md-5 col-md-offset-3">
					<button> <span>Save</span>
						<svg class="spinner" width="30px" height="30px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
							<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
						</svg>
					</button>
				</div>
				
			</form>
		</div>
	</div>
</div>
@endsection
<style>
</style>