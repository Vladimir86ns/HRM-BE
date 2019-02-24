<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentCreateRequest;
use App\Services\Department\DepartmentService;
use App\Transformers\Department\DepartmentTransformer;
use App\Validators\DepartmentValidator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use League\Fractal\Manager as Fractal;
use League\Fractal\Resource\Collection;

class DepartmentController extends Controller
{
    /**
     * @var \App\Services\Department\DepartmentService
     */
    protected $service;

    /**
     * @var \App\Validators\DepartmentValidator
     */
    protected $validator;

    /**
     * @var \App\Transformers\Department\DepartmentTransformer
     */
    protected $transformer;

    /**
     * @var \League\Fractal\Manager
     */
    protected $fractal;

    /**
     * DepartmentController constructor.
     *
     * @param DepartmentService     $departmentService
     * @param DepartmentValidator   $departmentValidator
     * @param DepartmentTransformer $departmentTransformer
     * @param Fractal               $fractal
     */
    public function __construct(
        DepartmentService $departmentService,
        DepartmentValidator $departmentValidator,
        DepartmentTransformer $departmentTransformer,
        Fractal $fractal
    ) {
        $this->service = $departmentService;
        $this->validator = $departmentValidator;
        $this->transformer = $departmentTransformer;
        $this->fractal = $fractal;
    }

    /**
     * Bulk save departments.
     *
     * @param $id Company ID
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|string
     */
    public function bulkSave($id, Request $request)
    {
        $inputs = $request->all();

        $errors = $this->validator->departmentCreateValidatorRulesAndCustomValidators(
            $inputs,
            new DepartmentCreateRequest()
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $departments = $this->service->bulkSaveDepartments($inputs);

        if (!$departments) {
            return response([ 'data' => []], Response::HTTP_OK);
        }

        $result = new Collection($departments, $this->transformer);

        return response(
            $this->fractal->createData($result)->toArray(),
            Response::HTTP_OK
        );
    }
}
