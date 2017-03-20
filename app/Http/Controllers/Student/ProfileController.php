<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Get Account Settings
     * @return \Illuminate\Http\Response
     */
    public function showTeacherProfile(Teacher $teacher)
    {
        return view('student.teacher', [
            'teacher' => $teacher,
            'isFriends' => Auth::guard('student')->user()->isFriendWith(Teacher::where('id', $teacher->id)->first()),
            'pendingFriendRequest' => $teacher->hasFriendRequestFrom(Auth::guard('student')->user()),
            'isTeacherAndStudentMet' => $this->isTeacherAndStudentMet($teacher->id),
            'interests' => json_decode($teacher->interests),
        ]);
    }

    /**
     * Get Teacher Rate
     * @param  int    $id
     * @return json
     */
    public function getTeacherRate(int $id)
    {
        $rate = DB::table('rates')->where([
                'rater_id' => Auth::guard('student')->user()->id,
                'rater_type' => 'App\Student',
                'rated_id' => $id,
                'rated_type' => 'App\Teacher',
            ])->first();

        if ($met == null) {
            return response()->json([
                'error' => false,
                'rate' => 0,
            ], 200);
        }

        return response()->json([
            'error' => false,
            'rate' => $rate->rate,
        ], 200);
    }

    /**
     * Save Teacher Rate
     * @param  Request $request
     * @return json
     */
    public function saveTeacherRate(Request $request)
    {
        $get = DB::table('rates')->where([
            'rater_id' => Auth::guard('student')->user()->id,
            'rater_type' => 'App\Student',
            'rated_id' => $request->teacher_id,
            'rated_type' => 'App\Teacher',
        ])->delete(); 


        DB::table('rates')->insert([
            'rater_id' => Auth::guard('student')->user()->id,
            'rater_type' => 'App\Student',
            'rated_id' => $request->teacher_id,
            'rated_type' => 'App\Teacher',
            'rate' => $request->rate,
        ]);

        return response()->json([
            'error' => false,
            'rate' => $request->rate,
        ]);
    }

    public function studentMetTeacher(Request $request)
    {
        DB::table('friendships')->where([
            'sender_type' => 'App\Student',
            'sender_id' => Auth::guard('student')->user()->id,
            'recipient_type' => 'App\Teacher',
            'recipient_id' => $request->teacher_id,
        ])
        ->orWhere([
            'sender_type' => 'App\Teacher',
            'sender_id' => $request->teacher_id,
            'recipient_type' => 'App\Student',
            'recipient_id' => Auth::guard('student')->user()->id,
        ])->update([
            'met' => 1,
        ]);

        return redirect()->back();
    }

    protected function isTeacherAndStudentMet(int $id) {
        $met = DB::table('friendships')->where([
            'sender_type' => 'App\Student',
            'sender_id' => Auth::guard('student')->user()->id,
            'recipient_type' => 'App\Teacher',
            'recipient_id' => $id,
        ])
        ->orWhere([
            'sender_type' => 'App\Teacher',
            'sender_id' => $id,
            'recipient_type' => 'App\Student',
            'recipient_id' => Auth::guard('student')->user()->id,
        ])->first();

        if ($met == null) {
            return false;
        }

        return $met;
    }
}
