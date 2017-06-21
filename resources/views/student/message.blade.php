@extends('student.layout.app')
@section('content')
<div class="container messages" ng-controller="StudentMessageController" ng-init="teacher_id={{ $teacher_id }}; getTeacherMessages()">
    <div class="row">
        <div class="messages">
        <header>{{ $teacher_name }}</header>
        <div class="messages-wrapper" id="messagesWrapper">
            <div class="message" ng-repeat="message in messages" ng-class="message.direction == 'from' ? 'from' : 'to'">@{{ message.message }}</div>
        </div>
        <div class="col-md-12">
            <input type="text" ng-model="message" ng-keypress="($event.charCode==13)?sendMessage():return">
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
// window.setInterval(function() {
//     var elem = document.getElementById('messagesWrapper');
//         elem.scrollTop = elem.scrollHeight;
// }, 100000);
</script>
<script src="/js/controllers/student/StudentMessageController.js"></script>
@endsection