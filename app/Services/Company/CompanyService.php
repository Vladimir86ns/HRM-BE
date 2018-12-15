<?php

namespace App\Services\Company;

use App\Account;
use App\Company;
use App\Department;
use App\Location;
use Illuminate\Support\Facades\DB;

class CompanyService
{
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
        $newName = $attributes['account_info']['name'];
        $newEmail = $attributes['account_info']['email'];

        $oldName = $account->name;
        $oldEmail = $account->name;

        if ($newName !== $oldName && $newEmail !== $oldEmail) {
            $account->email = $newEmail;
            $account->name = $newName;
            $account->save();
        } else if ($newEmail !== $oldEmail) {
            $account->email = $newEmail;
            $account->save();
        } else if ($newName !== $oldName) {
            $account->name = $newName;
            $account->save();
        }

        return $account;
    }
}
