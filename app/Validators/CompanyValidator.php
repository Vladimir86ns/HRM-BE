<?php

namespace App\Validators;

use App\Traits\ValidatorTrait;
use Validator;

class CompanyValidator
{
    use ValidatorTrait;

    /**
     * Validate response with rules, and all custom validations.
     *
     * @param array $inputs
     * @param       $validator
     *
     * @return array|mixed
     */
    public function validateWithRulesAndAllCustomValidations(array $inputs, $validator)
    {
        $errors = $this->createCompanySettings($inputs, $validator);

        if ($errors) {
            return $errors;
        }

        return [];
    }

    /**
     * Validate create account
     *
     * @param array $data
     * @param       $validator
     *
     * @return mixed
     */
    public function createCompanySettings(array $data, $validator)
    {
        // TODO add validation does email already exist on other company with different account id.
        return $this->validateData($data, $validator);
    }
}
