@extends('student.layout.app')
@section('content')
<div class="container profile" ng-controller="StudentTeacherController" ng-init="teacher_id={{ $teacher->id }}; getTeacherRateAndReview()" class="md-padding">
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
				<p>Interests: @foreach ($interests as $interest) {{ $interest }} @if ($interest != end($interests)) , @endif @endforeach</p>
				<p>Address: {{ $teacher->address }}</p>
				<p>Proficiency: {{ $teacher->proficiency }}</p>
				<p>Age: {{ \Carbon\Carbon::parse($teacher->date_of_birth)->diff(\Carbon\Carbon::now())->format('%y years') }}</p>
				<div class="row">
					<div class="col-md-12">
						@if ($isFriends)
							<button ng-click="removeFriend({{ $teacher->id }}, {{ $teacher->first_name }})">Remove</button>
						@endif

						@if (!$isFriends && !$pendingFriendRequest)
						<button id="addFriend" ng-click="sendFriendRequestToTeacher({{ $teacher->id }})">Add Friend</button>
						@endif

						@if ($pendingFriendRequest)
							<button class="pending" ng-click="removeFriend({{ $teacher->id }}, {{ $teacher->first_name }})">Pending Friend Request</button>
							<button ng-click="removeFriend({{ $teacher->id }}, {{ $teacher->first_name }})">Remove</button>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
			<div class="panel review">
				<div class="panel-heading">
					<p>Review</p>
				</div>
				<div class="panel-body">
					@if($isFriends && !$isTeacherAndStudentMet)
						<h1>If you met before click <a href="#" onclick="event.preventDefault(); document.getElementById('meet-form').submit()">HERE</a></h1>
						<form id="meet-form" action="{{ route('student.met.teacher') }}" method="POST">
							{{ csrf_field() }}
							<input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
						</form>
					@endif

					@if ($isFriends && $isTeacherAndStudentMet)
						<div class="col-md-12">
							<textarea name="review" placeholder="Write your review for teacher" ng-model="review"></textarea>
							<span class="max-letters">Max Letters 500</span>
						</div>
						<div class="col-md-12" ng-show="review != null">
							<button ng-click="sendReview({{ $teacher->id }})">Send Review</button>
						</div>
					@endif

					@if(!$isFriends)
						<div class="col-md-12">
							<h1>You should be friends, And meat to review</h1>
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="panel rate">
				<div class="panel-heading">
					<p>Rate</p>
				</div>
				<div class="panel-body">
					@if ($isFriends && $isTeacherAndStudentMet)
					<div class="col-md-12 rate">
						<ng-rate-it ng-model="rate" rated="rated" resetable="false">
						</ng-rate-it>
					</div>
					@else
					<div class="col-md-12 rate">
						<h1>You should be friends, And meat to review</h1>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('styles')
<link rel="stylesheet" href="/css/ng-rateit.min.css" />
@endsection

@section('scripts')
<script src="/js/ng-rateit.min.js"></script>

<script src="/js/controllers/student/StudentTeacherController.js"></script>
@endsection