<?php

namespace App\Validators;

use App\Company;
use App\Department;
use App\Position;
use App\Services\Position\PositionService;
use App\Traits\ValidatorTrait;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class PositionValidator
{
    use ValidatorTrait;

    /**
     * @var \App\Services\Position\PositionService
     */
    protected $service;

    /**
     * PositionValidator constructor.
     */
    public function __construct(PositionService $positionService)
    {
        $this->service = $positionService;
    }

    /**
     * Get position by id, and company Id, or throw exception not found position.
     *
     */
    public function getAndValidatePositionByIdAndCompanyId(int $id, int $companyId)
    {
        $this->validateId($id);
        $this->validateId($companyId);

        $position = $this->service->getPositionByIdAndCompanyId($id, $companyId);

        if (!$position) {
            abort(Response::HTTP_NOT_FOUND, 'Position not found!');
        }

        return $position;
    }

    /**
     * Validate create position, and all other custom validations.
     *
     * @param array $data
     * @param $validator
     * @return mixed
     */
    public function positionCreateValidatorRulesAndCustomValidators(array $data, $validator)
    {
        $errors = $this->validateData($data, $validator);

        if ($errors) {
            return $errors;
        }

        $positions = $data['positions'];

        $this->checkDoesCompanyBelongsToAccount($data);
        $this->checkDoesDepartmentBelongsToCompany($data);
        $this->checkPositionsNameDuplicationOnSameDepartment($positions);
        $this->checkDepartmentNamesDuplicationOnSameDepartment($positions);
        $this->checkNameAlreadyExistForGivenDepartment($positions);
    }

    /**
     * Check does name already exist for given department name.
     *
     * @param array $positions
     */
    public function checkNameAlreadyExistForGivenDepartment(array $positions)
    {
        $allExistingNames = [];

        foreach ($positions as $position) {
            $existingNames = Position::whereIn('name', $position['names'])->pluck('name')->toArray();

            if ($existingNames) {
                $names = implode(", ", $existingNames);
                $allExistingNames = array_merge($allExistingNames, [
                    "For {$position['department_name']} department, position name(s): {$names} already exist!"
                ]);
            }
        }

        if ($allExistingNames) {
            abort(Response::HTTP_NOT_ACCEPTABLE, implode("       ", $allExistingNames));
        }
    }

    /**
     * Check given position names are duplicated for department.
     *
     * @param array $positions
     */
    private function checkPositionsNameDuplicationOnSameDepartment(array $positions)
    {
        $allDuplicatedNames = [];

        foreach ($positions as $position) {
            $names = $position['names'];
            $duplicates = array_diff_key($names, array_unique($names));

            if ($duplicates) {
                $names = implode(", ", $duplicates);
                $allDuplicatedNames = array_merge($allDuplicatedNames, [
                    "For {$position['department_name']} department, position name(s): {$names} are duplicated!"
                ]);
            }
        }

        if ($allDuplicatedNames) {
            abort(Response::HTTP_NOT_ACCEPTABLE, implode("     ", $allDuplicatedNames));
        }
    }

    /**
     * Check does company belongs to given company id.
     *
     * @param array $data
     */
    private function checkDoesCompanyBelongsToAccount(array $data)
    {
        $company = Company::where([
                ['id', $data['company_id']],
                ['account_id', $data['account_id']]
            ])->exists();

        if (!$company) {
            abort(Response::HTTP_NOT_ACCEPTABLE, "Company does not belong to given account!");
        }
    }

    /**
     * Check does department belongs to given company id.
     *
     * @param array $data
     */
    private function checkDoesDepartmentBelongsToCompany(array $data)
    {
        $departmentIds = collect($data['positions'])->pluck('department_id')->unique()->toArray();
        $allDepartmentsIds = Department::where('company_id', $data['company_id'])->pluck('id')->toArray();
        $idsWhichNotBelongsToCompany = array_diff($departmentIds, $allDepartmentsIds);

        if ($idsWhichNotBelongsToCompany) {
            $names = collect($data['positions'])
                ->whereIn('department_id', $idsWhichNotBelongsToCompany)
                ->pluck('department_name')
                ->toArray();
            abort(Response::HTTP_NOT_ACCEPTABLE, "This department{s}:" . implode(" ,", $names) .
                " does not belogns to company!");
        }
    }

    /**
     * Check are department names are duplicated.
     *
     * @param array $positions
     */
    private function checkDepartmentNamesDuplicationOnSameDepartment(array $positions)
    {
        $departmentNames = collect($positions)->pluck('department_name')->toArray();
        $duplicates = array_diff_key($departmentNames, array_unique($departmentNames));

        if ($duplicates) {
            $names = implode(", ", $duplicates);
            abort(Response::HTTP_NOT_ACCEPTABLE,  "This department name(s): {$names} are duplicated!");
        }
    }
}
