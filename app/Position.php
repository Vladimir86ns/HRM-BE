<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $fillable = [
        'name',
        'company_id',
        'department_id',
    ];
}
