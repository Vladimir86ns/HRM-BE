<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $fillable = [
        'name',
        'description',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
