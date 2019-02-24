<?php

namespace App\Services\Department;

use App\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function bulkSaveDepartments(array $attributes)
    {
        DB::transaction(function () use ($attributes) {
            foreach ($attributes['departments'] as $department) {
                Department::create([
                    'name' => $department['name'],
                    'description' => $department['description'],
                    'company_id' => $department['company_id']
                ]);
            }
        });
        $companyId = $attributes['company_id'];

        return $this->getDepartmentsByCompanyId($companyId);
    }

    /**
     * @param int $companyId
     *
     * @return mixed
     */
    public function getDepartmentsByCompanyId(int $companyId)
    {
        return Department::where('company_id', $companyId)->get();
    }
}
