@extends('student.layout.app')
@section('content')
<div class="container home-blade" ng-controller="StudentHomeController">
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        Teachers meet you interests
                    </div>
                    <div class="panel-body">
                        <div class="teachers row">
                            <div ng-if="teachers.length == 0">
                                <h1 style="text-align: center;">
                                    No teachers meet your interests, don't be sad go to your <a href="{{route('student.account.settings') }}"> account </a> and start adding interests
                                </h1>
                            </div>
                            <md-list flex ng-if="teachers.length != 0">
                            <md-list-item class="md-3-line col-md-6"
                                ng-repeat="teacher in teachers | startFrom:currentPage*pageSize | limitTo:pageSize"
                                ng-click="showDate(teacher.id)"
                                >
                                <img ng-src="@{{ teacher.photo }}" class="md-avatar" alt="@{{teacher.first_name}}" />
                                <div class="md-list-item-text" layout="column">
                                    <h3>@{{ teacher.first_name }} @{{ teacher.last_name }}</h3>
                                    <h4>@{{ teacher.email }}</h4>
                                    <p>@{{ teacher.phone_number }}</p>
                                </div>
                            </md-list-item>
                            <div class="col-sm-12 col-lg-12 pagination" ng-if="teachers.length != 0">
                                <md-button class="md-fab md-primary" aria-label="Use Android" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
                                    <img ng-src="/img/back.png"></img>
                                </md-button>
                                @{{currentPage+1}} / @{{numberOfPages()}}
                                <md-button class="md-fab md-primary" aria-label="Use Android" ng-disabled="currentPage >= teachers.length/pageSize - 1" ng-click="currentPage=currentPage+1">
                                    <img ng-src="/img/next.png"></img>
                                </md-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-3">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        Analytics
                    </div>
                    <div class="panel-body">
                        <div class="signedTeachers col-sm-12">
                            <div class="img">
                                <img src="http://www.okclipart.com/img103/skbrhjqiugvahxtujhxi.jpg" alt="student">
                                <p>@{{ teachersCount}} Teacher</p>
                            </div>
                        </div>
                        <hr>
                        <div class="signedStudents col-sm-12">
                            <div class="img">
                                <img src="http://static.vectorcharacters.net/uploads/2013/02/Student_Vector_Character_Preview.jpg" alt="student">
                                <p>@{{ studentsCount }} Student</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="/js/controllers/student/StudentHomeController.js"></script>
@endsection