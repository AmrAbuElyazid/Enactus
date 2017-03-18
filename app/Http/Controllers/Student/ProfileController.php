<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Get Account Settings
     * @return \Illuminate\Http\Response
     */
    public function showTeacherProfile(Teacher $teacher)
    {
        // dd();
        return view('student.teacher', [
            'teacher' => $teacher,
            'isFriends' => Auth::guard('student')->user()->isFriendWith(Teacher::where('id', $teacher->id)->first()),
            'interests' => json_decode($teacher->interests),
        ]);   
    }

    public function getTeacherProfile(Teacher $teacher)
    {

    }
}
