<?php

Route::get('/', function () {
    if (Auth::guard('teacher')->check() == true) {
        return redirect(route('teacher.home'));
    }
    if (Auth::guard('student')->check() == true) {
        return redirect(route('student.home')) ;
    }

    return view('welcome');
})->name('welcome');

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
    });
});
