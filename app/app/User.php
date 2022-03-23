<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    public $incrementing = false;
    protected $primaryKey = 'userID';
    protected $fillable = [
        'userID', 'username', 'name', 'password', 'isAdmin', 'isMaster', 'isFA', 'isCreate', 'isUpdate', 'isDelete'
    ];
    protected $casts = [
        'isAdmin' => 'boolean',
        'isMaster' => 'boolean',
        'isFA' => 'boolean',
        'isCreate' => 'boolean',
        'isUpdate' => 'boolean',
        'isDelete' => 'boolean',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUserID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'USER-'.$time;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }
}
