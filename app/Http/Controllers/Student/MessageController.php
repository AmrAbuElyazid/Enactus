<?php

namespace App\Http\Controllers\Student;

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
        $teachersIds = DB::table('messages')->select( DB::raw('DISTINCT(sender_id)') )->where([
            'sender_type' => 'App\Teacher',
            'recipient_type' => 'App\Student',
            'recipient_id' => Auth::guard('student')->user()->id,
        ])->get();

        $teachers = [];
        foreach ($teachersIds as $id) {
            $teachers[] = Teacher::where('id', $id->sender_id)->select('id', 'first_name', 'last_name', 'photo')->get();
        }
        return view('student.allmessages', [
            'teachers' => $teachers,
        ]);
    }

    public function showMessagesPage(int $id)
    {
        return view('student.message', [
            'teacher_id' => $id,
            'teacher_name' => Teacher::where('id', $id)->first()->first_name . ' ' . Teacher::where('id', $id)->first()->last_name 
        ]);
    }

    public function getMessages(int $id)
    {
        $student_messages = DB::table('messages')->where([
                'sender_type' => 'App\Student',
                'sender_id' => Auth::guard('student')->user()->id,
                'recipient_type' => 'App\Teacher',
                'recipient_id' => $id,
            ])
            ->oRwhere([
                'sender_type' => 'App\Teacher',
                'sender_id' => $id,
                'recipient_type' => 'App\Student',
                'recipient_id' => Auth::guard('student')->user()->id,
            ])
            ->get();

        return response()->json([
            'error' => false,
            'messages' => $student_messages,
        ], 200);
    }

    public function getUnreadedMessage(int $id)
    {
        $messages = DB::table('messages')->where([
            'sender_type' => 'App\Teacher',
            'sender_id' => $id,
            'recipient_type' => 'App\Student',
            'recipient_id' => Auth::guard('student')->user()->id,
            'sender_read' => true,
            'recipient_read' => false,
        ])->get();

        return response()->json([
            'error' => false,
            'messages' => $messages,
        ], 200);
    }

    public function sendMessageToTeacher(Request $request)
    {
        DB::table('messages')
            ->insert([
                'sender_type' => 'App\Student',
                'sender_id' => Auth::guard('student')->user()->id,
                'recipient_type' => 'App\Teacher',
                'recipient_id' => $request->teacher_id,
                'sender_read' => true,
                'recipient_read' => false,
                'message' => $request->message,
            ]);
    }

    public function setAllMessagesToRead(int $id)
    {
        DB::table('messages')
            ->where([
                'sender_type' => 'App\Teacher',
                'sender_id' => $id,
                'recipient_type' => 'App\Student',
                'recipient_id' => Auth::guard('student')->user()->id,
            ])
            ->update([
                'sender_read' => 1,
                'recipient_read' => 1,
            ]);
    }

    public function showUnreadedMessagesPage()
    {
        return view('student.unreaded', [
            'teachers' => Student::getAllUnreededMessagesAndCount()['teachers'],
        ]);
    }
}
