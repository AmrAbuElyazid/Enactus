<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Student;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{

    public function showAllMessagesPage()
    {
        $studentsIds = DB::table('messages')->select( DB::raw('DISTINCT(sender_id)') )->where([
            'sender_type' => 'App\Student',
            'recipient_type' => 'App\Teacher',
            'recipient_id' => Auth::guard('teacher')->user()->id,
        ])->get();

        $students = [];
        foreach ($studentsIds as $id) {
            $students[] = Student::where('id', $id->sender_id)->select('id', 'first_name', 'last_name', 'photo')->get();
        }
        return view('teacher.allmessages', [
            'students' => $students,
        ]);
    }


    public function showMessagesPage(int $id)
    {
        return view('teacher.message', [
            'student_id' => $id,
            'student_name' => Student::where('id', $id)->first()->first_name . ' ' . Teacher::where('id', $id)->first()->last_name 
        ]);
    }

    public function getMessages(int $id)
    {
        $teacher_messages = DB::table('messages')->where([
                'sender_type' => 'App\Teacher',
                'sender_id' => Auth::guard('teacher')->user()->id,
                'recipient_type' => 'App\Student',
                'recipient_id' => $id,
            ])
            ->oRwhere([
                'sender_type' => 'App\Student',
                'sender_id' => $id,
                'recipient_type' => 'App\Teacher',
                'recipient_id' => Auth::guard('teacher')->user()->id,
            ])
            ->get();

        return response()->json([
            'error' => false,
            'messages' => $teacher_messages,
        ], 200);
    }

    public function getUnreadedMessage(int $id)
    {
        $messages = DB::table('messages')->where([
            'sender_type' => 'App\Student',
            'sender_id' => $id,
            'recipient_type' => 'App\Teacher',
            'recipient_id' => Auth::guard('teacher')->user()->id,
            'sender_read' => true,
            'recipient_read' => false,
        ])->get();

        return response()->json([
            'error' => false,
            'messages' => $messages,
        ], 200);
    }

    public function sendMessageToStudent(Request $request)
    {
        DB::table('messages')
            ->insert([
                'sender_type' => 'App\Teacher',
                'sender_id' => Auth::guard('teacher')->user()->id,
                'recipient_type' => 'App\Student',
                'recipient_id' => $request->student_id,
                'sender_read' => true,
                'recipient_read' => false,
                'message' => $request->message,
            ]);
    }

    public function setAllMessagesToRead(int $id)
    {
        DB::table('messages')
            ->where([
                'sender_type' => 'App\Student',
                'sender_id' => $id,
                'recipient_type' => 'App\Teacher',
                'recipient_id' => Auth::guard('teacher')->user()->id,
            ])
            ->update([
                'sender_read' => 1,
                'recipient_read' => 1,
            ]);
    }

    public function showUnreadedMessagesPage()
    {
        return view('teacher.unreaded', [
            'students' => Teacher::getAllUnreededMessagesAndCount()['students'],
        ]);
    }

}
