<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Get Account Settings
     * @return \Illuminate\Http\Response
     */
    public function showStudentProfile(Student $student)
    {
        return view('teacher.student', [
            'student' => $student,
            'isFriends' => Auth::guard('teacher')->user()->isFriendWith(Student::where('id', $student->id)->first()),
            'pendingFriendRequest' => $student->hasFriendRequestFrom(Auth::guard('teacher')->user()),
            'isTeacherAndStudentMet' => $this->isTeacherAndStudentMet($student->id),
            'interests' => json_decode($student->interests),
        ]);
    }

    /**
     * Get Teacher Rate
     * @param  int    $id
     * @return json
     */
    public function getStudentRate(int $id)
    {
        $rate = DB::table('rates')->where([
                'rater_id' => Auth::guard('teacher')->user()->id,
                'rater_type' => 'App\Teacher',
                'rated_id' => $id,
                'rated_type' => 'App\Student',
            ])->first();
        
        if ($rate == null) {
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

    public function getStudentReview(int $id)
    {
        $review = DB::table('reviews')->where([
            'reviewer_type' => 'App\Teacher',
            'reviewer_id' => Auth::guard('teacher')->user()->id,
            'reviewed_type' => 'App\Student',
            'reviewed_id' => $id,
        ])->first();

        if ($review == null) {
            return response()->json([
                'error' => false,
                'review' => null,
            ], 200);
        }

        return response()->json([
            'error' => false,
            'review' => $review->review, 
        ], 200);
    }

    /**
     * Save Teacher Rate
     * @param  Request $request
     * @return json
     */
    public function saveStudentRate(Request $request)
    {
        $get = DB::table('rates')->where([
            'rater_id' => Auth::guard('teacher')->user()->id,
            'rater_type' => 'App\Teacher',
            'rated_id' => $request->teacher_id,
            'rated_type' => 'App\Student',
        ])->delete(); 


        DB::table('rates')->insert([
            'rater_id' => Auth::guard('teacher')->user()->id,
            'rater_type' => 'App\Teacher',
            'rated_id' => $request->student_id,
            'rated_type' => 'App\Student',
            'rate' => $request->rate,
        ]);

        return response()->json([
            'error' => false,
            'rate' => $request->rate,
        ]);
    }

    public function teacherMetStudent(Request $request)
    {
        DB::table('friendships')->where([
            'sender_type' => 'App\Teacher',
            'sender_id' => Auth::guard('teacher')->user()->id,
            'recipient_type' => 'App\student',
            'recipient_id' => $request->student_id,
        ])
        ->orWhere([
            'sender_type' => 'App\Student',
            'sender_id' => $request->student_id,
            'recipient_type' => 'App\Teacher',
            'recipient_id' => Auth::guard('teacher')->user()->id,
        ])->update([
            'met' => 1,
        ]);

        return redirect()->back();
    }

    protected function isTeacherAndStudentMet(int $id) {
        $met = DB::table('friendships')->where([
            'sender_type' => 'App\Teacher',
            'sender_id' => Auth::guard('teacher')->user()->id,
            'recipient_type' => 'App\Student',
            'recipient_id' => $id,
        ])
        ->orWhere([
            'sender_type' => 'App\Student',
            'sender_id' => $id,
            'recipient_type' => 'App\Teacher',
            'recipient_id' => Auth::guard('teacher')->user()->id,
        ])->first();
        
        if ($met == null) {
            return false;
        }

        return $met->met;
    }

    public function saveReview(Request $request)
    {
        DB::table('reviews')->where([
            'reviewer_type' => 'App\Teacher',
            'reviewer_id' => Auth::guard('teacher')->user()->id,
            'reviewed_type' => 'App\Student',
            'reviewed_id' => $request->student_id,
        ])->delete();

        DB::table('reviews')->insert([
            'reviewer_type' => 'App\Teacher',
            'reviewer_id' => Auth::guard('teacher')->user()->id,
            'reviewed_type' => 'App\Student',
            'reviewed_id' => $request->student_id,
            'review' => $request->review,
        ]);
    }
}
