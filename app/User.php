<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name',
        'email',
        'password',
        'user_info_detail_id'
    ];

    /**
     * Create model, create user info details.
     *
     * @param  array  $attributes
     * @return $this
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public static function create(array $attributes = [])
    {
        $userInfoDetails = self::createUserInfo(array_only($attributes, ['first_name', 'last_name']));
        $attributes['user_info_detail_id'] = $userInfoDetails->id;
        $model = static::query()->create(array_only($attributes, ['password', 'user_info_detail_id']));

        return $model;
    }

    public static function createUserInfo(array $attributes)
    {
        return UserInfoDetails::create($attributes);
    }

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
