<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionCreateRequest;
use App\Services\Position\PositionService;
use App\Transformers\Position\PositionTransformer;
use App\Validators\CompanyValidator;
use App\Validators\PositionValidator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PositionController extends Controller
{
    /**
     * @var \App\Validators\PositionValidator
     */
    protected $validator;

    /**
     * @var \App\Services\Position\PositionService
     */
    protected $service;

    /**
     * @var \App\Transformers\Position\PositionTransformer
     */
    protected $transformer;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * PositionController constructor.
     *
     * @param PositionValidator   $validator
     * @param PositionService     $service
     * @param PositionTransformer $positionTransformer
     * @param Fractal             $fractal
     */
    public function __construct(
        PositionValidator $validator,
        PositionService $service,
        PositionTransformer $positionTransformer,
        Fractal $fractal
    ) {
        $this->validator = $validator;
        $this->service = $service;
        $this->transformer = $positionTransformer;
        $this->fractal = $fractal;
    }

    /**
     * Bulk save positions.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     */
    public function bulkSave(Request $request)
    {
        $inputs = $request->all();
        $errors = $this->validator->positionCreateValidatorRulesAndCustomValidators(
            $inputs,
            new PositionCreateRequest()
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $positions = $this->service->bulkSavePositions($inputs);
        $result = new Collection($positions, $this->transformer);

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }

    /**
     * Get all company positions.
     *
     * @param                  $id company ID
     * @param CompanyValidator $companyValidator
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCompanyPositions($id, CompanyValidator $companyValidator)
    {
        $company = $companyValidator->getAndValidateCompany($id);

        $paginator = $this->service->getAllCompanyPositionsAsPaginator($company->id);
        $positions = $paginator->getCollection();

        $result = new Collection($positions, $this->transformer);
        $result->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }
}
