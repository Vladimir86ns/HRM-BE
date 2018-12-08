<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    const SRB = 'SRB';

    protected $casts = [
        'is_supported' => 'boolean',
    ];
}
