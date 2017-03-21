@extends('teacher.layout.app')
@section('content')
<div class="container messages" ng-controller="TeacherMessageController" ng-init="student_id={{ $student_id }}; getTeacherMessages()">
    <div class="row">
        <div class="messages">
        <header>{{ $student_name }}</header>
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
<script src="/js/controllers/teacher/TeacherMessageController.js"></script>
@endsection