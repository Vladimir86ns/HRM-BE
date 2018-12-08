<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfoDetails extends Model
{
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
        'gender'
    ];

    public function user()
    {
        $this->hasOne(User::class);
    }
}
