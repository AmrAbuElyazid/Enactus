<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    use UploadImage;
    /**
     * Get Account Settings
     * @return \Illuminate\Http\Response
     */
    public function showAccountSettingsPage()
    {
        return view('teacher.account');   
    }

    /**
     * Return Account Settings
     * @return Json
     */
    public function getAccountSettings()
    {
        return response()->json([
            'teacher' => Auth::guard('teacher')->user(),
        ], 200);
    }

    /**
     * Update Account Settings
     * @param  Request $request
     * @return json
     */
    public function updateAccountSettings(Request $request) {
        $this->handleTeacherInterests($request->interests);
        if (is_array($request['photo'])) {
            $request['photo'] = $this->upload($request['photo'], 'business', 'base64');
        }
        
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|unique:students,email,'.Auth::guard('teacher')->user()->id,
        ]);
        
        Auth::guard('teacher')->user()->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'interests' => json_encode($request->interests, JSON_FORCE_OBJECT),
            'photo' => $request->photo,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'talent' => $request->talent,
            'proficiency' => $request->proficiency,
        ]);

        return response()->json([
            'errror' => 'false',
            'message' => 'Account Settings Updated Successfully',
        ], 200);
    }

    /**
     * Handle Teacher Interests and Tag
     * @param  array  $interests
     */
    protected function handleTeacherInterests(array $interests) {
        if (DB::table('teachers_tags')->get()->count() != 0) {
            DB::table('teachers_tags')
                ->where('teacher_id', Auth::guard('teacher')->user()->id)
                ->delete();
        }

        foreach ($interests as $tag) {
            DB::table('teachers_tags')
                ->insert([
                    'teacher_id' => Auth::guard('teacher')->user()->id,
                    'tag' => $tag,
                ]);
        }
    }
}
