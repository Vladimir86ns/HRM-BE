<?php

namespace App\Validators;

use App\Traits\ValidatorTrait;
use Validator;

class AccountValidator
{
    use ValidatorTrait;

    /**
     * Validate create account
     *
     * @param array $data
     * @param $validator
     * @return mixed
     */
    public function accountCreateValidator(array $data, $validator)
    {
        return $this->validateData($data, $validator);
    }
}
