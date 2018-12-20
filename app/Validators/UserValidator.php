<?php

namespace App\Validators;

use App\Services\User\UserService;
use App\Traits\ValidatorTrait;
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
}
