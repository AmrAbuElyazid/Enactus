@extends('student.layout.app')
@section('content')
<div class="container home-blade" ng-controller="StudentHomeController">
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">
                        Heading
                    </div>
                    <div class="panel-body">
                        test
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="col-lg-12">
                <div class="panel">
                    <div class="panel-heading">
                        Heading
                    </div>
                    <div class="panel-body">
                        test
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