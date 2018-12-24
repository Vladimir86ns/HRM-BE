<?php

namespace App\Services\Company;

use App\Account;
use App\Company;
use App\Employee;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    /**
     * Get company info by id.
     *
     * @param int $id
     * @return Company
     */
    public function getCompanyById(int $id)
    {
        return Company::find($id);
    }

    /**
     * Get companies by account Id.
     *
     * @param int $accountId
     * @return mixed
     */
    public function getCompanyByAccountId(int $accountId)
    {
        return Company::where('account_id', $accountId)->get();
    }

    /**
     * Get all company employees.
     *
     * @param int $companyId
     * @return mixed
     */
    public function getCompanyEmployees(int $companyId)
    {
        return Employee::where('company_id', $companyId)->get();
    }

    /**
     * Save company, location and department data. Update account if data is different
     * then on existing account.
     *
     * @param array $attributes
     * @return string
     */
    public function saveCompanySettings(array $attributes, Account $account)
    {
        return DB::transaction(function () use ($attributes, $account) {
            $this->checkChangesAccountAndUpdate($attributes, $account);

            foreach ($attributes['company_info'] as $companyAndLocation) {
                $companyAttributes = $this->getCompanyAttributes($companyAndLocation);
                $company = $account->companies()->create($companyAttributes);

                $locationAttributes = $this->getLocationAttributes($companyAndLocation);
                $company->location()->create($locationAttributes);

                foreach ($companyAndLocation['department_info'] as $department) {
                    $departmentAttributes = $this->getDepartmentAttributes($department);
                    $company->departments()->create($departmentAttributes);
                }
            }

            return $company;
        });
    }

    /**
     * Update company, location, department and account info.
     *
     * @param Company $company
     * @param array   $attributes
     * @return Company
     */
    public function updateCompany(Company $company, array $attributes)
    {
        return DB::transaction(function () use ($attributes, $company) {
            $this->checkChangesAccountAndUpdate($attributes, $company->account);

            foreach ($attributes['company_info'] as $companyAndLocation) {
                $companyAttributes = $this->getCompanyAttributes($companyAndLocation);
                $company->update($companyAttributes);

                $locationAttributes = $this->getLocationAttributes($companyAndLocation);
                $company->location()->update($locationAttributes);

                foreach ($companyAndLocation['department_info'] as $department) {
                    $departmentAttributes = $this->getDepartmentAttributes($department);
                    $company->departments()->update($departmentAttributes);
                }
            }

            return $company;
        });
    }

    /**
     * Get company attributes.
     *
     * @param array $companyAndLocation
     * @return array
     */
    private function getCompanyAttributes(array $companyAndLocation)
    {
        return array_merge(
            $companyAndLocation['company'],
            ['country_id' => $companyAndLocation['location']['country_id']]
        );
    }

    /**
     * Get location attributes.
     *
     * @param array $companyAndLocation
     * @return array
     */
    private function getLocationAttributes(array $companyAndLocation)
    {
        return array_except($companyAndLocation['location'], 'country_id');
    }

    /**
     * Get department attributes.
     *
     * @param array $companyAndLocation
     * @return array
     */
    private function getDepartmentAttributes(array $companyAndLocation)
    {
        return array_only($companyAndLocation, ['name', 'description']);
    }

    /**
     * Check account name and email and update it, if it is different.
     *
     * @param array $attributes
     * @param Account $account
     * @return Account
     */
    private function checkChangesAccountAndUpdate(array $attributes, Account $account)
    {
        $newName = $attributes['account_info']['name'] ?? null;
        $newEmail = $attributes['account_info']['email'] ?? null;

        $oldName = $account->name;
        $oldEmail = $account->name;

        if ($newName && $newName !== $oldName && $newEmail !== $oldEmail) {
            $account->email = $newEmail;
            $account->name = $newName;
            $account->save();
        } else if ($newEmail && $newEmail !== $oldEmail) {
            $account->email = $newEmail;
            $account->save();
        } else if ($newName && $newName !== $oldName) {
            $account->name = $newName;
            $account->save();
        }

        return $account;
    }
}
