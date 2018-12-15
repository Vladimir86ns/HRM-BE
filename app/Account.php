<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'setup_progress'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
