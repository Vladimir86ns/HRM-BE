<?php

namespace App\Traits;

use App\Company;
use Validator;
use Symfony\Component\HttpFoundation\Response;

trait ValidatorTrait
{
    /**
     * Validate data
     *
     * @param array $data
     * @param $validator
     * @return mixed
     */
    public function validateData(array $data, $validator)
    {
        $validator = Validator::make($data, $validator->rules(), $validator->messages());

        if ($validator->fails()) {
            return $validator->errors()->messages();
        }

        return [];
    }

    public function validateId($id)
    {
        if (!is_numeric($id)) {
            abort(Response::HTTP_BAD_REQUEST, 'Id must be integer!');
        }
    }

    /**
     * Check does company belongs to given company id.
     *
     * @param array $data
     */
    public function checkDoesCompanyBelongsToAccount(array $data)
    {
        $company = Company::where([
            ['id', $data['company_id']],
            ['account_id', $data['account_id']]
        ])->exists();

        if (!$company) {
            abort(Response::HTTP_NOT_ACCEPTABLE, "Company does not belong to given account!");
        }
    }
}
