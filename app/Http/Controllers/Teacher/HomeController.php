<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Return Teacher With same interests as student
     * @return Json
     */
    public function getSameInterestsStudents()
    {
        $studentTags = DB::table('students_tags')->where('student_id', Auth::guard('teacher')->user()->id)->pluck('tag');
        $data = collect();

        foreach ($studentTags as $tag) {
            $data = $data->merge(
                DB::table('students_tags')
                              ->where('tag', 'LIKE', "%$tag%")
                              ->pluck('student_id')
            );
        }
        
        $students = [];
        foreach (array_unique($data->toArray()) as $id) {
            $students[]= $this->getStudentInfoById($id);
        }

        return response()->json([
            'error' => false,
            'students' => $students,
        ], 200);

    }

    /**
     * Get teacher info by id
     * @param  int    $id Teacher id
     * @return collection     Teacher Info
     */
    public function getStudentInfoById(int $id)
    {
        $student = Student::where('id', $id)->first();
        $teacher = Auth::guard('teacher')->user();
        return [
            'student' => Student::where('id', $id)->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'interests', 'address', 'photo', 'date_of_birth')->first(),
            'pendingFriendRequest' => $student->hasFriendRequestFrom($teacher),
            'isFriend' => $teacher->isFriendWith($student),
        ];    
    }

}
