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
        
        <div class="cd-search is-hidden">
            <form action="#0">
                <input type="search" placeholder="Search...">
            </form>
        </div> <!-- cd-search -->

        <a href="#0" class="cd-nav-trigger">Menu<span></span></a>

        <nav class="cd-nav">
            <ul class="cd-top-nav">
                <li><a href="#0">Tour</a></li>
                <li><a href="#0">Support</a></li>
                <li class="has-children account">
                    <a href="#0">
                        <img src="/img/cd-avatar.png" alt="avatar">
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
                <li class="has-children overview">
                    <a href="#0">Overview</a>
                    
                    <ul>
                        <li><a href="#0">All Data</a></li>
                        <li><a href="#0">Category 1</a></li>
                        <li><a href="#0">Category 2</a></li>
                    </ul>
                </li>
                <li class="has-children notifications active">
                    <a href="#0">Notifications<span class="count">3</span></a>
                    
                    <ul>
                        <li><a href="#0">All Notifications</a></li>
                        <li><a href="#0">Friends</a></li>
                        <li><a href="#0">Other</a></li>
                    </ul>
                </li>

                <li class="has-children comments">
                    <a href="#0">Comments</a>
                    
                    <ul>
                        <li><a href="#0">All Comments</a></li>
                        <li><a href="#0">Edit Comment</a></li>
                        <li><a href="#0">Delete Comment</a></li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="cd-label">Secondary</li>
                <li class="has-children bookmarks">
                    <a href="#0">Bookmarks</a>
                    
                    <ul>
                        <li><a href="#0">All Bookmarks</a></li>
                        <li><a href="#0">Edit Bookmark</a></li>
                        <li><a href="#0">Import Bookmark</a></li>
                    </ul>
                </li>
                <li class="has-children images">
                    <a href="#0">Images</a>
                    
                    <ul>
                        <li><a href="#0">All Images</a></li>
                        <li><a href="#0">Edit Image</a></li>
                    </ul>
                </li>

                <li class="has-children users">
                    <a href="#0">Users</a>
                    
                    <ul>
                        <li><a href="#0">All Users</a></li>
                        <li><a href="#0">Edit User</a></li>
                        <li><a href="#0">Add User</a></li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="cd-label">Action</li>
                <li class="action-btn"><a href="#0">+ Button</a></li>
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