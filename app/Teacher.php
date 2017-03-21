<?php

namespace App;

use App\Notifications\TeacherResetPassword;
use App\Student;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Teacher extends Authenticatable
{
    use Notifiable, Friendable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TeacherResetPassword($token));
    }

    public static function getAllUnreededMessagesAndCount()
    {
        $studentsIds = DB::table('messages')->select( DB::raw('DISTINCT(sender_id)') )->where([
            'sender_type' => 'App\Student',
            'recipient_type' => 'App\Teacher',
            'recipient_id' => Auth::guard('teacher')->user()->id,
            'recipient_read' => false,
        ])->get();

        $students = [];
        foreach ($studentsIds as $id) {
            $students[] = Student::where('id', $id->sender_id)->select('id', 'first_name', 'last_name', 'photo')->get();
        }

        return [
            'error' => false,
            'students' => $students,
            'count' => count($students),

        ];
    }

}
