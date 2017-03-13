<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

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
            'student' => Auth::guard('teacher')->user(),
        ], 200);
    }

    /**
     * Update Account Settings
     * @param  Request $request
     * @return json
     */
    public function updateAccountSettings(Request $request) {
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
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return response()->json([
            'errror' => 'false',
            'message' => 'Account Settings Updated Successfully',
        ], 200);
    }
}
