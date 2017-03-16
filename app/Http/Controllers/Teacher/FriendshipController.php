<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadImage;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public function showFirendsPage() {
        return view('teacher.friends');
    }

    public function showPendingRequestsPage()
    {
        return view('teacher.pending');
    }

    public function getAllTeacherFriends()
    {
        $sent = DB::table('friendships')
            ->where(['sender_type' => 'App\Teacher', 'sender_id' => Auth::guard('teacher')->user()->id])
            ->select('recipient_id')
            ->get();

        $reseved = DB::table('friendships')
            ->where(['sender_type' => 'App\Student', 'recipient_id' => Auth::guard('teacher')->user()->id])
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
            $friends[] = $this->getStudentInfoById($id);
        }

        return response()->json([
            'error' => false,
            'friends' => $friends,
        ], 200);
    }

    public function getPendingFriendRequests()
    {

        $reseved = DB::table('friendships')
            ->where(['sender_type' => 'App\Student', 'status' => 0, 'recipient_id' => Auth::guard('teacher')->user()->id])
            ->select('sender_id')
            ->get();

        $friendsIds = [];

        foreach ($reseved->toArray() as $value) {
            $friendsIds[] = $value->sender_id;
        }

        $friends = [];
        foreach ($friendsIds as $id) {
            $friends[] = $this->getStudentInfoById($id);
        }

        return response()->json([
            'error' => false,
            'friends' => $friends,
        ], 200);
    }

    protected function getStudentInfoById(int $id)
    {
        $teacher = Auth::guard('teacher')->user();
        $student = Student::where('id', $id)->first();
        return [
            'student' => Student::where('id', $id)->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'interests', 'address', 'photo', 'date_of_birth')->first(),
            'pendingFriendRequest' => $student->hasFriendRequestFrom($teacher),
            'teacherHasPendingFriendRequest' => $teacher->hasFriendRequestFrom($student),
            'isFriend' => $student->isFriendWith($teacher),
        ];
    }

    /**
     * Send Friend Request to Teacher
     * @param  integer $id teacher.id
     * @return json
     */
    public function sendFriendRequestToStudent($id)
    {
        Auth::guard('teacher')->user()->befriend(Student::where('id', $id)->first());
        
        return response()->json([
            'error' => false,
            'message' => 'Friend request sent successfully'
        ], 200);
    }

    public function accpetTeacherFriendRequest($id)
    {
        Auth::guard('teacher')->user()->acceptFriendRequest(Student::where('id', $id)->first());
    }

    /**
     * Remove Teacher From Friends
     * @param  integer $id teacher.id
     * @return json 
     */
    public function removeTeacherFromFriends($id)
    {
        Auth::guard('teacher')->user()->unfriend(Student::where('id', $id)->first());
    }

    public function sendMessageToStudent(Request $request, $id)
    {
        dd($request->all());
    }
}
