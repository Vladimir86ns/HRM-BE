<?php

namespace App\Traits;

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
}
