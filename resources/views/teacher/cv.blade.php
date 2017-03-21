@extends('teacher.layout.app')
@section('content')
<div class="container" 	id="container">
	<div class="row">
		<div class="panel">
			<div class="panel-heading">
				<p>Upload Your CV</p>
			</div>
			<div class="panel-body">
				@if(Session::has('status'))
				<div>
					<h1>
						CV Uploaded Succeefully 	
					</h1>
				</div>
				@endif
				<form action="{{ url('/teacher/cv') }}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="file" name="cv">
					<input type="submit" value="Upload" style="border: none; border-radius: 3px; width: 90px;">
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')

@endsection