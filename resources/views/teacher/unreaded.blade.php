@extends('teacher.layout.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="panel">
			<div class="panel-heading">
				<p>Unreaded Messages</p>
			</div>
			<div class="panel-body">
				@if(count($students) > 0)
					@foreach($students as $student)
						<div class="col-md-6">
						<a href="/teacher/messages/{{ $student['0']['id'] }}">
						<img src="{{ $student['0']['photo'] }}" alt="" style="width: 70px; height: 70px; border-radius: 70px; float: left; margin-right: 20px;">
						<p style="margin-top:25px;">{{ $student['0']['first_name'] }} {{ $student['0']['last_name'] }}</p>
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