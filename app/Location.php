<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $fillable = [
        'name',
        'company_id',
        'is_headquarters',
        'country',
        'region',
        'city',
        'zip_code',
        'first_address_line',
        'second_address_line',
    ];

    public $casts = [
        'is_headquarters' => 'boolean',
    ];

    public function company()
    {
        $this->hasOne(Company::class);
    }
}
