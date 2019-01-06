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
     * @var \App\Validators\CompanyValidator
     */
    protected $companyValidator;

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
     * @param CompanyValidator    $companyValidator
     * @param PositionService     $service
     * @param PositionTransformer $positionTransformer
     * @param Fractal             $fractal
     */
    public function __construct(
        PositionValidator $validator,
        CompanyValidator $companyValidator,
        PositionService $service,
        PositionTransformer $positionTransformer,
        Fractal $fractal
    ) {
        $this->validator = $validator;
        $this->companyValidator = $companyValidator;
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
     * @param $id Company ID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getPositions($id)
    {
        $company = $this->companyValidator->getAndValidateCompany($id);

        $paginator = $this->service->getAllCompanyPositionsAsPaginator($company->id);
        $positions = $paginator->getCollection();

        $result = new Collection($positions, $this->transformer);
        $result->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }

    /**
     * Delete position by id.
     *
     * @param $id Company Id
     * @param $positionId Position Id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deletePositions($id, $positionId)
    {
        $this->companyValidator->getAndValidateCompany($id);
        $position = $this->validator->getAndValidatePositionByIdAndCompanyId($positionId, $id);
        $position->delete();

        return response(
            $positionId,
            Response::HTTP_OK
        );
    }
}
