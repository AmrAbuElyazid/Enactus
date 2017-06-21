<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    use UploadImage;
    /**
     * Get Account Settings
     * @return \Illuminate\Http\Response
     */
    public function showAccountSettingsPage()
    {
        return view('student.account');   
    }

    /**
     * Return Account Settings
     * @return Json
     */
    public function getAccountSettings()
    {
        return response()->json([
            'student' => Auth::guard('student')->user(),
        ], 200);
    }

    /**
     * Update Account Settings
     * @param  Request $request
     * @return json
     */
    public function updateAccountSettings(Request $request) {
        $this->handleStudentInterests($request->interests);
        
        if (is_array($request['photo'])) {
            $request['photo'] = $this->upload($request['photo'], 'business', 'base64');
        }

        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:students,email,'.Auth::guard('student')->user()->id,
        ]);
        
        Auth::guard('student')->user()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'interstst' => json_encode($request->interests, JSON_FORCE_OBJECT),
            'photo' => $request->photo,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json([
            'errror' => 'false',
            'message' => 'Account Settings Updated Successfully',
        ], 200);
    }

    /**
     * Handle Student Interests and Tag
     * @param  array  $interests
     */
    protected function handleStudentInterests(array $interests) {
        if (DB::table('students_tags')->get()->count() != 0) {
            DB::table('students_tags')
                ->where('student_id', Auth::guard('student')->user()->id)
                ->delete();
        }

        foreach ($interests as $tag) {
            DB::table('students_tags')
                ->insert([
                    'student_id' => Auth::guard('student')->user()->id,
                    'tag' => $tag,
                ]);
        }
    }
}
