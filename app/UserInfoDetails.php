<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfoDetails extends Model
{
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_OTHER = 'other';

    const GENDER_TYPES = [
        self::GENDER_FEMALE,
        self::GENDER_MALE,
        self::GENDER_OTHER
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'gender'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }
}
