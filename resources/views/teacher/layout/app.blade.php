<!DOCTYPE html>
<html lang="en" ng-app="app">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <!doctype html>
    <html lang="en" class="no-js">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- CSRF Token -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <title>{{ config('app.name', 'Student|Dashboard') }}</title>
            <link rel="stylesheet" href="https://rawgit.com/angular/bower-material/master/angular-material.css">
            
            <!-- Styles -->
            <link rel="stylesheet" href="/css/reset.css">
            <link rel="stylesheet" href="/css/bootstrap.css">
            <link rel="stylesheet" href="/css/style.css"> <!-- Resource style -->
            <link href="/css/app.css" rel="stylesheet">
            @yield('styles')
            <!-- Scripts -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.9/angular.js"></script>
            <script src="/js/modernizr.js"></script> <!-- Modernizr -->
            <script>
            window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
            ]); ?>
            </script>
            
            <title>Enactus</title>
        </head>
        <body>
            <header class="cd-main-header">
                <a href="#0" class="cd-logo"><img src="/img/cd-logo.svg" alt="Logo"></a>
                
                <div class="is-hidden">
                    <form action="#0">
                        {{-- <input type="search" placeholder="Search..."> --}}
                    </form>
                    </div> <!-- cd-search -->
                    <a href="#0" class="cd-nav-trigger">Menu<span></span></a>
                    <nav class="cd-nav">
                        <ul class="cd-top-nav">
                            <li class="has-children account">
                                <a href="#0">
                                    <img src="{{ Auth::guard('teacher')->user()->photo }}" alt="avatar">
                                    Account
                                </a>
                                <ul>
                                    <li><a href="{{ route('teacher.account.settings') }}">Account Settings</a></li>
                                    <li><a href="#" id="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Logout</a></li>
                                    
                                    <form action="{{ route('teacher.logout') }}" id="logout-form" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    </header> <!-- .cd-main-header -->
                    <main class="cd-main-content">
                    <nav class="cd-side-nav">
                        <ul>
                            <li class="cd-label">Main</li>
                            <li class="has-children messages {{ Request::is('/teacher/messages') ? 'active' : '' }}">
                                <a href="#0">Messages <span class="count">{{ \App\Teacher::getAllUnreededMessagesAndCount()['count'] }}</span></a>
                                
                                <ul>
                                    <li><a href="{{ url('/teacher/messages') }}">All Messages</a></li>
                                    <li><a href="{{ url('/teacher/unreaded') }}">Unreaded Messages <span class="count">{{ \App\Teacher::getAllUnreededMessagesAndCount()['count'] }}</span></a></li>
                                </ul>
                            </li>
                            <li class="has-children notifications">
                                <a href="#">Notifications<span class="count">{{ \App\Teacher::getAllUnreededMessagesAndCount()['count'] }}</span></a>
                                
                                <ul>
                                    <li><a href="{{ url('/teacher/messages') }}">Messages <span class="count">{{ \App\Teacher::getAllUnreededMessagesAndCount()['count'] }}</span></a></li>
                                    <li><a href="{{ url('/teacher/friends/pending') }}">Friends</a></li>
                                </ul>
                            </li>
                            <li class="has-children users">
                                <a href="#0">Friends</a>
                                <ul>
                                    <li>
                                        <a href="{{ url('/teacher/friends') }}">All Friends
                                            <span class="count">
                                                {{ Auth::guard('teacher')->user()->getAllFriendships()->count() }}
                                            </span>
                                        </a>
                                    </li>
                                    <li><a href="{{ url('/teacher/friends/pending') }}">Pending Friend Requests
                                        <span class="count">
                                            {{ Auth::guard('teacher')->user()->getPendingFriendships()->count() }}
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <ul>
                        <li class="cd-label">Secondary</li>
                        <li class="has-children bookmarks">
                            <a href="#0">CV</a>
                            
                            <ul>
                                <li><a href="{{ url('/teacher/cv') }}">Upload CV</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <div class="content-wrapper">
                    @yield('content')
                    </div> <!-- .content-wrapper -->
                    </main> <!-- .cd-main-content -->

                    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
                    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
                    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
                    <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
                    <script src="/js/jquery-2.1.4.js"></script>
                    <script src="/js/jquery.menu-aim.js"></script>
                    <script src="/js/app.js"></script>
                    <script src="/js/main.js"></script> <!-- Resource jQuery -->
                    @yield('scripts')
                </body>
            </html>