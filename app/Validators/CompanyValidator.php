<?php

namespace App\Validators;

use App\Services\Company\CompanyService;
use App\Traits\ValidatorTrait;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class CompanyValidator
{
    use ValidatorTrait;

    /**
     * @var \App\Services\Company\CompanyService
     */
    protected $service;

    /**
     * CompanyValidator constructor.
     */
    public function __construct(CompanyService $companyService)
    {
        $this->service = $companyService;
    }

    /**
     * Get company by id, or throw exception not found company.
     *
     * @param int $id
     * @return \App\Company
     */
    public function getAndValidateCompany(int $id)
    {
        $this->validateId($id);

        $company = $this->service->getCompanyById($id);

        if (!$company) {
            abort(Response::HTTP_NOT_FOUND, 'Company not found!');
        }

        return $company;
    }

    /**
     * Validate response with rules, and all custom validations.
     *
     * @param array $inputs
     * @param       $validator
     *
     * @return array|mixed
     */
    public function onCreateValidateWithRulesAndAllCustomValidations(array $inputs, $validator)
    {
        $this->validateAccountAlreadyHasCompany($inputs['account_info']['account_id']);

        $errors = $this->validateAttributes($inputs, $validator);

        if ($errors) {
            return $errors;
        }

        return [];
    }

    public function onUpdateValidateWithRulesAndAllCustomValidations(array $inputs, $validator)
    {
        $errors = $this->validateAttributes($inputs, $validator);

        if ($errors) {
            return $errors;
        }

        return [];
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
        // TODO add validation does email already exist on other company with different account id.
        // TODO add validation company name already exist for given company id.
        return $this->validateData($data, $validator);
    }

    private function validateAccountAlreadyHasCompany($account_id)
    {
        $companies = $this->service->getCompanyByAccountId($account_id);

        if ($companies->isNotEmpty()) {
            abort(Response::HTTP_NOT_ACCEPTABLE, 'It is not possible to have more then one company!');
        }
    }
}
