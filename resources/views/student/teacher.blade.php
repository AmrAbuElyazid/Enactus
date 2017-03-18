@extends('student.layout.app')
@section('content')
<div class="container profile" ng-controller="StudentTeacherController" data-ng-init="" class="md-padding">
	<div class="row">
		<img src="{{ $teacher->photo }}" alt="">
		<div class="panel info">
			<div class="panel-heading">
				{{ $teacher->first_name }}
			</div>

			<div class="panel-body">
				<p>Name: {{ $teacher->first_name }} {{ $teacher->last_name }} </p>
				<p>Email: <a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a></p>
				<p>Phone Number: {{ $teacher->phone_number }}</p>
				<p>Interests @foreach ($interests as $interest) {{ $interest }} @if ($interest != end($interests)) , @endif @endforeach</p>
				<p>Address: {{ $teacher->address }}</p>
				<p>Proficiency: {{ $teacher->proficiency }}</p>
				<p>Date Of Birth: {{ $teacher->date_of_birth }}</p>
				<div class="row">
					<div class="col-md-12">
						@if ($isFriends) 
							<button ng-onclick="removeFriend({{ $teacher->id }})">Remove</button>
						@else
							<button ng-onclick="addFriend({{ $teacher->id }})">Add Friend</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel rate">
			<div class="panel-heading">
				<p>Rate/Review</p>
			</div>
			<div class="panel-body">
				<div class="col-md-12 review">
					<textarea name="review" placeholder="Write your review for teacher"></textarea>
					<span class="max-letters">Max Letters 500</span>
				</div>
				<div class="col-md-12">
					<p>Rating</p>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="/js/controllers/student/StudentTeacherController.js"></script>
@endsection