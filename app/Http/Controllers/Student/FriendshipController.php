<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadImage;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public function showFirendsPage() {
        return view('student.friends');
    }

    public function showPendingRequestsPage()
    {
        return view('student.pending');
    }

    public function getAllStudentFriends()
    {
        $sent = DB::table('friendships')
            ->where(['sender_type' => 'App\Student', 'sender_id' => Auth::guard('student')->user()->id])
            ->select('recipient_id')
            ->get();

        $reseved = DB::table('friendships')
            ->where(['sender_type' => 'App\Teacher', 'recipient_id' => Auth::guard('student')->user()->id])
            ->select('sender_id')
            ->get();

        $friendsIds = [];
        foreach ($sent->toArray() as $value) {
            $friendsIds[] = $value->recipient_id;
        }
        foreach ($reseved->toArray() as $value) {
            $friendsIds[] = $value->sender_id;
        }

        $friends = [];
        foreach ($friendsIds as $id) {
            $friends[] = $this->getTeacherInfoById($id);
        }

        return response()->json([
            'error' => false,
            'friends' => $friends,
        ], 200);
    }

    public function getPendingFriendRequests()
    {

        $reseved = DB::table('friendships')
            ->where(['sender_type' => 'App\Teacher', 'status' => 0, 'recipient_id' => Auth::guard('student')->user()->id])
            ->select('sender_id')
            ->get();

        $friendsIds = [];

        foreach ($reseved->toArray() as $value) {
            $friendsIds[] = $value->sender_id;
        }

        $friends = [];
        foreach ($friendsIds as $id) {
            $friends[] = $this->getTeacherInfoById($id);
        }

        return response()->json([
            'error' => false,
            'friends' => $friends,
        ], 200);
    }

    protected function getTeacherInfoById(int $id)
    {
        $teacher = Teacher::where('id', $id)->first();
        $student = Auth::guard('student')->user();
        return [
            'teacher' => Teacher::where('id', $id)->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'interests', 'address', 'photo', 'date_of_birth')->first(),
            'pendingFriendRequest' => $teacher->hasFriendRequestFrom($student),
            'studentHasPendingFriendRequest' => $student->hasFriendRequestFrom($teacher),
            'isFriend' => $student->isFriendWith($teacher),
        ];
    }

    /**
     * Send Friend Request to Teacher
     * @param  integer $id teacher.id
     * @return json
     */
    public function sendFriendRequestToTeacher($id)
    {
        Auth::guard('student')->user()->befriend(Teacher::where('id', $id)->first());
        
        return response()->json([
            'error' => false,
            'message' => 'Friend request sent successfully'
        ], 200);
    }

    public function accpetTeacherFriendRequest($id)
    {
        Auth::guard('student')->user()->acceptFriendRequest(Teacher::where('id', $id)->first());
    }

    /**
     * Remove Teacher From Friends
     * @param  integer $id teacher.id
     * @return json 
     */
    public function removeTeacherFromFriends($id)
    {
        Auth::guard('student')->user()->unfriend(Teacher::where('id', $id)->first());
    }

    public function sendMessageToTeacher(Request $request, $id)
    {
        dd($request->all());
    }
}
