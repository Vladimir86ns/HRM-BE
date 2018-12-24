<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $fillable = [
        'company_id',
        'payroll_group_id',
        'user_info_detail_id',
        'company_employee_id',
        'birthdate',
        'telephone_number',
        'mobile_number',
        'hours_per_day',
        'date_hired',
        'date_ended',
        'location_id',
        'department_id',
        'country',
        'region',
        'city',
        'zip_code',
        'first_address_line',
        'second_address_line',
        'position_id'
    ];

    public function userInfoDetail()
    {
        return $this->belongsTo(UserInfoDetails::class, 'user_info_detail_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
