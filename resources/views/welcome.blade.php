<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Learn|Teach</title>
        <meta name="description" content="Blueprint: Split Layout" />
        <meta name="keywords" content="website template, layout, css3, transition, effect, split, dual, two sides, portfolio" />
        <meta name="author" content="Codrops" />
        <link rel="shortcut icon" href="../favicon.ico">
        <link rel="stylesheet" type="text/css" href="css/default.css" />
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/component2.css" />
        <script src="js/modernizr.custom.js"></script>
    </head>
    <body>
        <div class="container">
            <div id="splitlayout" class="splitlayout">
                <div class="intro">
                    <div class="side side-left">
                        <div class="intro-content">
                            <div class="profile"><img src="http://static.vectorcharacters.net/uploads/2013/02/Student_Vector_Character_Preview.jpg" alt="profile1"></div>
                            <h1><span>Student</span><span>Start Learning</span></h1>
                        </div>
                        <div class="overlay"></div>
                    </div>
                    <div class="side side-right">
                        <div class="intro-content">
                            <div class="profile"><img src="http://www.okclipart.com/img103/skbrhjqiugvahxtujhxi.jpg" alt="profile2"></div>
                            <h1><span>Teacher</span><span>Start Teaching</span></h1>
                        </div>
                        <div class="overlay"></div>
                    </div>
                </div>
                <!-- /intro -->
                <div class="page page-right">
                    <div class="page-inner">
                        <div class="main signin">
                            <form class="cbp-mc-form" action="{{ route('teacher.login') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="cbp-mc-column">                                   
                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="jon@doe.com">
                                </div>

                                <div class="cbp-mc-column">                                   
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" placeholder="**********">
                                </div>

                                <div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="Sign In"/></div>
                            </form>
                        </div>
                        <div class="main signup">
                            <pre>
                                @if($errors)
                                   @foreach ($errors->all() as $error)
                                      <div>{{ $error }}</div>
                                  @endforeach
                                @endif
                            </pre>
                            <form class="cbp-mc-form" action="{{ route('teacher.register') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="cbp-mc-column">
                                    <label for="first_name">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Jonathan">
                                    
                                    <label for="last_name">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Doe">

                                    <label for="email">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="jon@doe.com">

                                    <label for="phone_numbers">Phone Number</label>
                                    <input type="text" id="phone_numbers" name="phone_number" placeholder="+351 999 999">
    
                                </div>

                                <div class="cbp-mc-column">
                                    <label for="">Password</label>
                                    <input type="password" id="password" name="password" placeholder="**********" required>

                                    
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="**********" required>

                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Cairo, Egypt">

                                    <label for="interests">Your Interests</label>
                                    <textarea id="interests" name="interests"></textarea>
                                </div>

                                <div class="cbp-mc-column">
                                    <label>Talent</label>
                                    <input type="text" name="talent" placeholder="What will you teach">
                                    <label>Proficiency</label>
                                    <select id="proficiency" name="proficiency">
                                        <option>Choose</option>
                                        <option>Beginner</option>
                                        <option>Intermediate</option>
                                        <option>Expert</option>
                                    </select>

                                    <label for="comment">Leave A Comment</label>
                                    <textarea id="comment" name="comment"></textarea>
                                </div>
                                <div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="Sign Up"/></div>
                            </form>
                        </div>
                    </div>
                    <!-- /page-inner -->
                </div>
                <!-- /page-right -->
                <div class="page page-left">
                    <div class="page-inner">
                        <div class="main signin">
                            <form class="cbp-mc-form" action="{{ route('student.login') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="cbp-mc-column">                                   
                                    <label for="">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="jon@doe.com" required>

                                </div>
                                <div class="cbp-mc-column">                                   
                                    <label for="">Password</label>
                                    <input type="password" id="password" name="password" placeholder="**********" required>
                                </div>

                                <div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="Sign In"/></div>
                            </form>
                        </div>
                        <div class="main signup">
                            <form class="cbp-mc-form" action="{{ route('student.register') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="cbp-mc-column">
                                    <label for="">First Name</label>
                                    <input type="text" id="first_name" name="first_name" placeholder="Jonathan" required>
                                    
                                    <label for="">Password</label>
                                    <input type="password" id="password" name="password" placeholder="**********" required>

                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" id="phone_number" name="phone_number" placeholder="+351 999 999" required>
                                </div>

                                <div class="cbp-mc-column">
                                    <label for="">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" placeholder="Doe" required>

                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="**********" required>

                                    <label for="">Address</label>
                                    <input type="text" id="address" name="address" placeholder="Cairo, Egypt" required>

                                </div>

                                <div class="cbp-mc-column">
                                    <label for="">Email Address</label>
                                    <input type="email" id="email" name="email" placeholder="jon@doe.com" required>

                                    <label for="date_of_birth">Date Of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                                </div>
                                <div class="cbp-mc-submit-wrap"><input class="cbp-mc-submit" type="submit" value="Sign Up"/></div>
                            </form>
                        </div>
                    </div>
                    <!-- /page-inner -->
                </div>
                <!-- /page-left -->
                <a href="#" class="back back-right" title="back to intro">&rarr;</a>
                <a href="#" class="back back-left" title="back to intro">&larr;</a>
            </div>
            <!-- /splitlayout -->
        </div>
        <!-- /container -->
        <script src="js/classie.js"></script>
        <script src="js/cbpSplitLayout.js"></script>
    </body>
</html>