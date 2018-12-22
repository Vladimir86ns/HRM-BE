<?php

namespace App\Validators;

use App\Services\User\UserService;
use App\Traits\ValidatorTrait;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class UserValidator
{
    use ValidatorTrait;

    /**
     * @var \App\Services\User\UserService
     */
    protected $service;

    /**
     * UserValidator constructor.
     *
     * @param \App\Services\Account\AccountService $service
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * Validate and get user by id.
     *
     * @param int $id
     * @return mixed
     */
    public function getAndValidateUserById(int $id)
    {
        $this->validateId($id);
        $user = $this->service->getUserById($id);

        if (!$user) {
            abort(Response::HTTP_NOT_FOUND, 'User not found!');
        }

        return $user;
    }

    /**
     * Validate all rules on update user info.
     *
     * @param array $inputs
     * @param       $validator
     * @param User  $user
     *
     * @return array|mixed
     */
    public function onUpdateValidateWithRulesAndAllCustomValidations(array $inputs, $validator, User $user)
    {
        $this->doesUserBelongsGivenAccountId($inputs, $user);
        $errors = $this->validateAttributes($inputs, $validator);

        if ($errors) {
            return $errors;
        }

        return $inputs;
    }

    /**
     * Validate create account
     *
     * @param array $data
     * @param       $validator
     *
     * @return mixed
     */
    public function validateAttributes(array $data, $validator)
    {
        return $this->validateData($data, $validator);
    }

    /**
     * Check does user belongs to the given account..
     *
     * @param array $inputs
     * @param User  $user
     */
    private function doesUserBelongsGivenAccountId(array $inputs, User $user)
    {
        if ($user->account->id !== $inputs['account_id']) {
            abort(Response::HTTP_NOT_ACCEPTABLE, 'The user does not belong to the given account!');
        }
    }
}
