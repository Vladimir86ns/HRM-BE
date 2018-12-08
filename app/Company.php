<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'logo',
        'email',
        'website',
        'mobile_phone',
        'telephone_number',
        'fax_number',
        'country_id',
        'account_id'
    ];

    public function account()
    {
        $this->hasOne(Account::class);
    }

    public function user()
    {
        $this->hasMany(User::class);
    }
}
