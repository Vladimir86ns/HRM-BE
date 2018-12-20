<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Services\Company\CompanyService;
use App\Transformers\Company\CompanyTransformer;
use App\Transformers\CustomSerializer\CustomSerializer;
use App\Validators\AccountValidator;
use App\Validators\CompanyValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Item;

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
     * @var \App\Transformers\Company\CompanyTransformer
     */
    protected $transformer;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * CompanyController constructor.
     */
    public function __construct(
        CompanyService $companyService,
        CompanyValidator $companyValidator,
        AccountValidator $accountValidator,
        CompanyTransformer $companyTransformer,
        Fractal $fractal
    ) {
        $this->service = $companyService;
        $this->validator = $companyValidator;
        $this->accountValidator = $accountValidator;
        $this->transformer = $companyTransformer;
        $this->fractal = $fractal;
    }

    /**
     * Get company by Id.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCompany($id)
    {
        $company = $this->validator->getAndValidateCompany((int) $id);

        $result = new Item($company, $this->transformer);
        $this->fractal->parseIncludes(['location', 'departments']);
        $this->fractal->createData($result)->toArray();

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }

    /**
     * Save company info in DB.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function saveCompanyInfo(Request $request)
    {
        $inputs = $request->all();

        $errors = $this->validator->onCreateValidateWithRulesAndAllCustomValidations(
            $inputs,
            new CompanyCreateRequest($inputs)
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $account = $this->accountValidator->getAndValidateAccountById($inputs['account_info']['account_id']);

        try {
            $company = $this->service->saveCompanySettings($inputs, $account);
        } catch (Exception $e) {
            \Log::info($e->getMessage() . ' : save company info');
            response(
                'Something went wrong, please try again later!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $result = new Item($company, $this->transformer);
        $this->fractal->parseIncludes(['location', 'departments']);
        $this->fractal->createData($result)->toArray();

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }

    /**
     * Update company by id.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateCompanyInfo(Request $request, $id)
    {
        $inputs = $request->all();

        $company = $this->validator->getAndValidateCompany((int) $id);

        $errors = $this->validator->onUpdateValidateWithRulesAndAllCustomValidations(
            $inputs,
            new CompanyUpdateRequest($inputs)
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        try {
            $updatedCompany = $this->service->updateCompany($company, $inputs);
        } catch (Exception $e) {
            \Log::info($e->getMessage() . ' : Update company, location, department, account info');
            response(
                'Something went wrong, please try again later!',
                Response::HTTP_BAD_REQUEST
            );
        }

        $result = new Item($updatedCompany, $this->transformer);
        $this->fractal->parseIncludes(['location', 'departments']);
        $this->fractal->createData($result)->toArray();

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }
}
