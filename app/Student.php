<?php

namespace App;

use App\Notifications\StudentResetPassword;
use App\Teacher;
use Hootlex\Friendships\Traits\Friendable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Student extends Authenticatable
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
        $this->notify(new StudentResetPassword($token));
    }


    public static function getAllUnreededMessagesAndCount()
    {
        $teachersIds = DB::table('messages')->select( DB::raw('DISTINCT(sender_id)') )->where([
            'sender_type' => 'App\Teacher',
            'recipient_type' => 'App\Student',
            'recipient_id' => Auth::guard('student')->user()->id,
            'recipient_read' => false,
        ])->get();

        $teachers = [];
        foreach ($teachersIds as $id) {
            $teachers[] = Teacher::where('id', $id->sender_id)->select('id', 'first_name', 'last_name', 'photo')->get();
        }

        return [
            'error' => false,
            'teachers' => $teachers,
            'count' => count($teachers),

        ];
    }
}
