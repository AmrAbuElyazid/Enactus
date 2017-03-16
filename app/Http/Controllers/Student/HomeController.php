<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Return Teacher With same interests as student
     * @return Json
     */
    public function getSameInterestsTeachers()
    {
        $studentTags = DB::table('students_tags')->where('student_id', Auth::guard('student')->user()->id)->pluck('tag');
        $data = collect();

        foreach ($studentTags as $tag) {
            $data = $data->merge(
                DB::table('teachers_tags')
                              ->where('tag', 'LIKE', "%$tag%")
                              ->pluck('teacher_id')
            );
        }
        
        $teachers = [];
        foreach (array_unique($data->toArray()) as $id) {
            $teachers[]= $this->getTeacherInfoById($id);
        }

        return response()->json([
            'error' => false,
            'teachers' => $teachers,
        ], 200);

    }

    /**
     * Get teacher info by id
     * @param  int    $id Teacher id
     * @return collection     Teacher Info
     */
    public function getTeacherInfoById(int $id)
    {
        return Teacher::where('id', $id)->select('id', 'first_name', 'last_name', 'email', 'phone_number', 'interests', 'address', 'photo', 'date_of_birth')->first();
    }

}
