<?php

namespace App\Validators;

use App\Services\Account\AccountService;
use App\Traits\ValidatorTrait;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class AccountValidator
{
    use ValidatorTrait;

    /**
     * @var \App\Services\Account\AccountService
     */
    protected $service;

    /**
     * AccountValidator constructor.
     */
    public function __construct(AccountService $accountService)
    {
        $this->service = $accountService;
    }

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

    /**
     * Validate and get account by id.
     *
     * @param int $id
     * @return mixed
     */
    public function getAndValidateAccountById(int $id)
    {
        $account = $this->service->getAccountById($id);

        if (!$account) {
            abort(Response::HTTP_NOT_FOUND, 'Account not found!');
        }

        return $account;
    }
}
