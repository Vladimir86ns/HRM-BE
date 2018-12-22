<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Services\User\UserService;
use App\Transformers\User\UserTransformer;
use App\Validators\UserValidator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var \App\Transformers\User\UserTransformer
     */
    protected $transformer;

    /**
     * @var \App\Validators\UserValidator;
     */
    protected $validator;

    /**
     * @var \App\Services\User\UserService
     */
    protected $service;

    /**
     * UserController constructor.
     */
    public function __construct(
        UserTransformer $userTransformer,
        UserValidator $userValidator,
        UserService $userService
    ) {
        $this->transformer = $userTransformer;
        $this->validator = $userValidator;
        $this->service = $userService;
    }

    /**
     * Get user by id.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getUser($id)
    {
        $user = $this->validator->getAndValidateUserById((int) $id);

        return response(
            $this->transformer->transform($user),
            Response::HTTP_OK
        );
    }

    /**
     * Update user info.
     *
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        $inputs = $request->all();

        $user = $this->validator->getAndValidateUserById((int) $id);
        $inputs['user_info_detail_id'] = $user->userInfo->id;

        $errors = $this->validator->onUpdateValidateWithRulesAndAllCustomValidations(
            $inputs,
            new UserProfileUpdateRequest($inputs),
            $user
        );

        if ($errors) {
            return response($errors, Response::HTTP_NOT_ACCEPTABLE);
        }

        $updatedUser = $this->service->updateUser($user, $inputs);

        return response(
            $this->transformer->transform($updatedUser),
            Response::HTTP_OK
        );
    }
}
