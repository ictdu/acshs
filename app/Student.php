<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    // use Notifiable;
    protected $table = 'student';
    protected $guard = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'track_id', 'lrn', 'firstname', 'middlename', 'lastname', 'gender', 'birthday', 'contact', 'religion', 'address1', 'address2', 'barangay', 'municipality', 'province', 'guardian', 'password',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function track(){
        return $this->belongsTo('App\Track');
    }
}
