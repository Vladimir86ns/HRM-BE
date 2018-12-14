<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanySettingsRequest;
use App\Services\Company\CompanyService;
use App\Validators\AccountValidator;
use App\Validators\CompanyValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    /**
     * @var \App\Services\Company\CompanyService
     */
    protected $service;

    /**
     * @var \App\Validators\CompanyValidator
     */
    protected $validator;

    /**
     * @var \App\Validators\AccountValidator
     */
    protected $accountValidator;

    /**
     * CompanyController constructor.
     */
    public function __construct(
        CompanyService $companyService,
        CompanyValidator $companyValidator,
        AccountValidator $accountValidator
    ) {
        $this->service = $companyService;
        $this->validator = $companyValidator;
        $this->accountValidator = $accountValidator;
    }

    /**
     * Save company settings in DB.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function saveInitialCompanySettings(Request $request)
    {
        $inputs = $request->all();

        $errors = $this->validator->validateWithRulesAndAllCustomValidations(
            $inputs,
            new CompanySettingsRequest($inputs)
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $account = $this->accountValidator->getAndValidateAccountById($inputs['account_info']['account_id']);

        try {
            $this->service->saveCompanySettings($inputs, $account);
        } catch (Exception $e) {
            response(
                'Something went wrong, please try again later!',
                Response::HTTP_BAD_REQUEST
            );
        }

        return response('Account successfully created!', Response::HTTP_OK);
    }
}
