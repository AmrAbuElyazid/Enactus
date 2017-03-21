@extends('student.layout.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="panel">
			<div class="panel-heading">
				<p>All Messages</p>
			</div>
			<div class="panel-body">
				@if(count($teachers) > 0)
					@foreach($teachers as $teacher)
						<div class="col-md-6">
						<a href="/student/messages/{{ $teacher['0']['id'] }}">
						<img src="{{ $teacher['0']['photo'] }}" alt="" style="width: 70px; height: 70px; border-radius: 70px; float: left; margin-right: 20px;">
						<p style="margin-top:25px;">{{ $teacher['0']['first_name'] }} {{ $teacher['0']['last_name'] }}</p>
						</a>
						</div>
					@endforeach
				@else
					<h1>No Messages</h1>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection