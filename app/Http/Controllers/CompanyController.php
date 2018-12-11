<?php

namespace App\Http\Controllers;

use App\Account;
use App\Http\Requests\CompanySettingsRequest;
use App\Services\Company\CompanyService;
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
     * CompanyController constructor.
     */
    public function __construct(
        CompanyService $companyService,
        CompanyValidator $companyValidator
    ) {
        $this->service = $companyService;
        $this->validator = $companyValidator;
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

        $errors = $this->validator->validateWithRulesAndAllCustomValidations($inputs, new CompanySettingsRequest());

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $account = Account::find($inputs['account_info']['account_id']);

        if (!$account) {
            return response('Account not found!', Response::HTTP_NOT_FOUND);
        }

        try {
            $this->service->saveCompanySettings($inputs);
        } catch (Exception $e) {
            response(
                'Something went wrong, please try again later!',
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE
            );
        }

        return response('Account successfully created!', Response::HTTP_OK);
    }
}
