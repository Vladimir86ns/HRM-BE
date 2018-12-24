<?php

namespace App\Transformers\Employee;

use App\Employee;
use League\Fractal\TransformerAbstract;

class EmployeeTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Employee $account
     * @return array
     */
    public function transform(Employee $employee)
    {
        return [
            'first_name' => $employee->userInfoDetail->first_name,
            'middle_name' => $employee->userInfoDetail->middle_name,
            'last_name' => $employee->userInfoDetail->last_name,
            'email' => $employee->userInfoDetail->email,
            'city' => $employee->location->city,
            'company_employee_id' => $employee->company_employee_id,
            'telephone_number' => $employee->telephone_number,
            'mobile_number' => $employee->mobile_number,
            'hours_per_day' => $employee->hours_per_day,
            'date_hired' => $employee->date_hired,
            'date_ended' => $employee->date_ended,
            'country' => $employee->location->country,
            'region' => $employee->location->region,
            'zip_code' => $employee->location->zip_code,
            'first_address_line' => $employee->location->first_address_line,
            'second_address_line' => $employee->location->second_address_line
        ];
    }
}
