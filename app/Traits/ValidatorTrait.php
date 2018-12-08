<?php

namespace App\Traits;

use Validator;

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
}
