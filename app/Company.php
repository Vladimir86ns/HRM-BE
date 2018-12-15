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
        return $this->hasOne(Account::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
