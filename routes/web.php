<?php

use App\Student;
use App\Teacher;

Route::get('/', function () {
    if (Auth::guard('teacher')->check() == true) {
        return redirect(route('teacher.home'));
    }
    if (Auth::guard('student')->check() == true) {
        return redirect(route('student.home')) ;
    }

    return view('welcome');
})->name('welcome');

Route::get('student/teachers/count', function () {
    return response()->json([
        'teachersCount' => Teacher::all()->count(),
        'studentsCount' => Student::all()->count(),
    ], 200);
});

Route::group(['prefix' => 'teacher'], function () {
    Route::post('/login', 'TeacherAuth\LoginController@login')->name('teacher.login');
    Route::post('/logout', 'TeacherAuth\LoginController@logout')->name('teacher.logout');
    Route::post('/register', 'TeacherAuth\RegisterController@register')->name('teacher.register');

    Route::post('/password/email', 'TeacherAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'TeacherAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'TeacherAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'TeacherAuth\ResetPasswordController@showResetForm');


    Route::group(['middleware' => 'teacher'], function () {
        Route::get('/settings', 'Teacher\TeacherController@showAccountSettingsPage')->name('teacher.account.settings');
        Route::get('/settings/get', 'Teacher\TeacherController@getAccountSettings')->name('teacher.get.account.settings');
        Route::patch('/settings/update', 'Teacher\TeacherController@updateAccountSettings')->name('teacher.account.update');

        Route::get('/get/match/students', 'Teacher\HomeController@getSameInterestsStudents');
        Route::get('/get/student/{id}', 'Teacher\HomeController@getStudentInfoById');

        // Friendships routes
        Route::get('/friends', 'Teacher\FriendshipController@showFirendsPage')->name('teacher.friends');
        Route::get('/get/friends', 'Teacher\FriendshipController@getAllTeacherFriends')->name('teacher.friends.get');
        Route::get('/friends/pending', 'Teacher\FriendshipController@showPendingRequestsPage')->name('teacher.requests.pending');
        Route::get('/get/pending', 'Teacher\FriendshipController@getPendingFriendRequests')->name('teacger.friends.get.pending');

        Route::post('/accept/student/{id}', 'Teacher\FriendshipController@accpetTeacherFriendRequest');
        Route::post('/send/toStudent/{id}', 'Teacher\FriendshipController@sendFriendRequestToStudent');

        // messages
        Route::post('/message/{id}', 'Teacher\FriendshipController@sendMessageToTeacher');
        Route::post('/delete/{id}', 'Teacher\FriendshipController@removeTeacherFromFriends');

        // teachers profile
        Route::get('/student/{student}', 'Teacher\ProfileController@showStudentProfile');
        Route::get('/rate/{id}', 'Teacher\ProfileController@getStudentRate');
        Route::post('/rate', 'Teacher\ProfileController@saveStudentRate');
        Route::post('/met/teacher', 'Teacher\ProfileController@teacherMetStudent')->name('teacher.met.student');

    });

});

Route::group(['prefix' => 'student'], function () {
    Route::post('/login', 'StudentAuth\LoginController@login')->name('student.login');   
    Route::post('/logout', 'StudentAuth\LoginController@logout')->name('student.logout');
    Route::post('/register', 'StudentAuth\RegisterController@register')->name('student.register');

    Route::post('/password/email', 'StudentAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'StudentAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'StudentAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'StudentAuth\ResetPasswordController@showResetForm');

    Route::group(['middleware' => 'student'], function () {
        Route::get('/settings', 'Student\StudentController@showAccountSettingsPage')->name('student.account.settings');
        Route::get('/settings/get', 'Student\StudentController@getAccountSettings')->name('student.get.account.settings');
        Route::patch('/settings/update', 'Student\StudentController@updateAccountSettings')->name('student.account.update');

        Route::get('/get/match/teachers', 'Student\HomeController@getSameInterestsTeachers');
        Route::get('/get/teacher/{id}', 'Student\HomeController@getTeacherInfoById');

        // Friendships routes
        Route::get('/friends', 'Student\FriendshipController@showFirendsPage')->name('friends');
        Route::get('/get/friends', 'Student\FriendshipController@getAllStudentFriends')->name('friends.get');
        Route::get('/friends/pending', 'Student\FriendshipController@showPendingRequestsPage')->name('requests.pending');
        Route::get('/get/pending', 'Student\FriendshipController@getPendingFriendRequests')->name('friends.get.pending');
        Route::post('/accept/teacher/{id}', 'Student\FriendshipController@accpetTeacherFriendRequest');
        Route::post('/send/toTeacher/{id}', 'Student\FriendshipController@sendFriendRequestToTeacher');

        // messages
        Route::post('/message/{id}', 'Student\FriendshipController@sendMessageToTeacher');
        Route::post('/delete/{id}', 'Student\FriendshipController@removeTeacherFromFriends');

        // teachers profile
        Route::get('/teacher/{teacher}', 'Student\ProfileController@showTeacherProfile');
        Route::get('/rate/{id}', 'Student\ProfileController@getTeacherRate');
        Route::post('/rate', 'Student\ProfileController@saveTeacherRate');
        Route::post('/met/teacher', 'Student\ProfileController@studentMetTeacher')->name('student.met.teacher');

    });
});
