<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountCreateRequest;
use App\Services\Account\AccountService;
use App\Transformers\Account\AccountTransformer;
use App\Validators\AccountValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountController extends Controller
{
    /**
     * @var \App\Validators\AccountValidator
     */
    protected $validator;

    /**
     * @var \App\Services\Account\AccountService
     */
    protected $service;

    /**
     * @var \App\Transformers\Account\AccountTransformer
     */
    protected $transformer;

    /**
     * AccountController constructor.
    */
    public function __construct(
        AccountValidator $accountValidator,
        AccountService $accountService,
        AccountTransformer $accountTransformer
    ) {
        $this->validator = $accountValidator;
        $this->service = $accountService;
        $this->transformer = $accountTransformer;
    }

    /**clear
     * Store a newly created account.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $inputs = $request->all();

        $errors = $this->validator->accountCreateValidator($inputs, new AccountCreateRequest());

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $account = $this->service->createAccountAndUserWithPassword($inputs);
        $result = $this->transformer->transform($account);

        return response($result, Response::HTTP_OK);
    }
}
