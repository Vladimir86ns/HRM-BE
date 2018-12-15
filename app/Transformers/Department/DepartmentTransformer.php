<?php

namespace App\Transformers\Account;

use App\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Department $department
     * @return array
     */
    public function transform(Department $department)
    {
        return [
            'id' => $department->id,
            'name' => $department->name,
            'description' => $department->description
        ];
    }
}
