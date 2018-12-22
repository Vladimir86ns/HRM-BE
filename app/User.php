<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const USER_STATUS_ACTIVE = 'active';
    const USER_STATUS_INACTIVE = 'inactive';

    const TYPE_OWNER = 'owner';
    const TYPE_SUPER_ADMIN = 'super_admin';
    const TYPE_ADMIN = 'admin';
    const TYPE_EMPLOYEE = 'employee';

    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    CONST USER_GENDER_TYPES = [
        self::GENDER_MALE,
        self::GENDER_FEMALE,
        self::GENDER_OTHER
    ];

    CONST USER_TYPES = [
        self::TYPE_OWNER,
        self::TYPE_SUPER_ADMIN,
        self::TYPE_ADMIN,
        self::TYPE_EMPLOYEE
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'status',
        'user_info_detail_id'
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
     * Get the user's type.
     *
     * @param  string  $value
     * @return string
     */
    public function getUserTypeAttribute($value)
    {
        return str_replace('_', ' ', $value);
    }

    /**
     * Set the user's type.
     *
     * @param  string  $value
     * @return void
     */
    public function setUserTypeAttribute($value)
    {
        $this->attributes['user_type'] = strtolower(str_replace(' ', '_', $value));
    }

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
        $model = static::query()->create(array_only(
            $attributes,
            ['password', 'user_info_detail_id', 'user_type', 'status']
        ));

        return $model;
    }

    /**
     * On creating user, create and user info fot that user.
     */
    public static function createUserInfo(array $attributes)
    {
        return UserInfoDetails::create($attributes);
    }

    /**
     * Get the account record associated with the user.
     */
    public function account()
    {
        return $this->hasOne(Account::class);
    }

    /**
     * Get the user info.
     */
    public function userInfo()
    {
        return $this->belongsTo(UserInfoDetails::class, 'user_info_detail_id');
    }

    /**
     * The companies that belong to the user.
     */
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
