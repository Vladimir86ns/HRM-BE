<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function account()
    {
        $this->hasOne(Account::class);
    }

    public function userInfo()
    {
        $this->belongsTo(UserInfoDetails::class);
    }

    public function companies()
    {
        return $this->belongsToMany(
            UserCompany::class,
            'user_companies',
            'company_id',
            'user_id'
        );
    }
}
