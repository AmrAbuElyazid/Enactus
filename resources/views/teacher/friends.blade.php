@extends('teacher.layout.app')
@section('content')
<div class="container" ng-controller="TeacherFriendshipController" class="md-padding">
	<div class="col-md-3" ng-repeat="friend in friends | startFrom:currentPage*pageSize | limitTo:pageSize">
		<md-card ng-show="!friend.teacherHasPendingFriendRequest">
		
		<md-card-header>
			<md-card-avatar>
            	<img class="md-user-avatar" ng-src="@{{ friend.student.photo }}"/>
          </md-card-avatar>
		<md-card-header-text>
		<span class="md-title" style="margin-left: 15px;">@{{ friend.student.first_name }} @{{ friend.student.last_name }}</span>
		<span class="md-subhead" style="margin-left: 15px;">@{{ friend.student.email }}</span>
		</md-card-header-text>
		</md-card-header>
		<md-card-actions layout="row" layout-align="end center">

          <md-button class="md-fab md-primary md-hue-2 md-mini" aria-label="Message"  ng-click="sendMessageToTeacher(friend.student.id)">
            <img src="/img/message.png" style="margin-left: -2px;"></img>
        </md-button>
          <md-button class="md-fab md-primary md-mini" aria-label="Settings" ng-click="showDate(friend.student.id)">
            <img src="/img/info.png" style="margin-left: -2px; margin-top: -2px;"></img>
          </md-button>
          <md-button class="md-fab md-mini" aria-label="Remove" ng-click="removeFriend(friend.student.id, friend.student.first_name)">
            <img src="/img/remove.png" style="margin-left: -4px; margin-top: -2px;"></img>
        </md-button>
        </md-card-actions>
		</md-card-actions>
		</md-card>
	</div>
	<div class="col-sm-12 col-lg-12 pagination" ng-show="friends.length != 0">
	    <md-button class="md-fab md-primary" aria-label="Use Androids" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
	        <img ng-src="/img/back.png"></img>
	    </md-button>
	    @{{currentPage+1}} / @{{numberOfPages()}}
	    <md-button class="md-fab md-primary" aria-label="Use Android" ng-disabled="currentPage >= friends.length/pageSize - 1" ng-click="currentPage=currentPage+1">
	        <img ng-src="/img/next.png"></img>
	    </md-button>
	</div>
	
</div>
@endsection
@section('scripts')
<script src="/js/controllers/teacher/TeacherFriendshipController.js"></script>
@endsection