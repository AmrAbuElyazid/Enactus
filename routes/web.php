<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'teacher'], function () {
    Route::post('/login', 'TeacherAuth\LoginController@login')->name('teacher.login');
    
    Route::post('/logout', 'TeacherAuth\LoginController@logout')->name('teacher.logout');

    Route::post('/register', 'TeacherAuth\RegisterController@register')->name('teacher.register');

    Route::post('/password/email', 'TeacherAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'TeacherAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'TeacherAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'TeacherAuth\ResetPasswordController@showResetForm');
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
        Route::get('/settings', 'StudentController@getAccountSettings')->name('account.settings');
        Route::patch('/settings/update', 'StudentController@updateAccountSettings')->name('account.update');
    });
});
