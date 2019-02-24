<?php

namespace App\Validators;

use Illuminate\Support\Arr;
use App\Department;
use App\Traits\ValidatorTrait;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class DepartmentValidator
{
    use ValidatorTrait;

    /**
     * Validate create department, and all other custom validations.
     *
     * @param array $data
     * @param $validator
     * @return mixed
     */
    public function departmentCreateValidatorRulesAndCustomValidators(array $data, $validator)
    {
        $errors = $this->validateData($data, $validator);

        if ($errors) {
            return $errors;
        }

        $departments = $data['departments'];

        $this->checkDoesCompanyBelongsToAccount($data);
        $this->checkDepartmentNameDuplication($departments);
        $this->checkNameAlreadyExistForGivenDepartment($departments);
    }


    /**
     * Validate update position, and all other custom validations.
     *
     * @param array $data
     * @param $validator
     * @return mixed
     */
    public function positionUpdateValidatorRulesAndCustomValidators(array $data, $validator)
    {
        $errors = $this->validateData($data, $validator);

        if ($errors) {
            return $errors;
        }
    }

    /**
     * Check does name already exist for given department name.
     *
     * @param array $departments
     */
    public function checkNameAlreadyExistForGivenDepartment(array $departments)
    {
        $allExistingNames = [];
        $names = Arr::pluck($departments, 'name');

        $existingNames = Department::whereIn('name', $names)->pluck('name')->toArray();

        if ($existingNames) {
            $names = implode(", ", $existingNames);
            $allExistingNames = array_merge($allExistingNames, [
                "This department name(s): {$names} already exist!"
            ]);
        }

        if ($allExistingNames) {
            abort(Response::HTTP_NOT_ACCEPTABLE, implode("       ", $allExistingNames));
        }
    }

    /**
     * Check given department names are duplicated.
     *
     * @param array $deparmtnes
     */
    private function checkDepartmentNameDuplication(array $deparments)
    {
        $allDuplicatedNames = [];

        $names = Arr::pluck($deparments, 'name');
        $duplicates = array_diff_key($names, array_unique($names));

        if ($duplicates) {
            $names = implode(", ", $duplicates);
            $allDuplicatedNames = array_merge($allDuplicatedNames, [
                "This department name(s): {$names} are duplicated!"
            ]);
        }

        if ($allDuplicatedNames) {
            abort(Response::HTTP_NOT_ACCEPTABLE, implode("     ", $allDuplicatedNames));
        }
    }
}
