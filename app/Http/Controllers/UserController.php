<?php

namespace App\Http\Controllers;

use App\Transformers\User\UserTransformer;
use App\Validators\UserValidator;
use Symfony\Component\HttpFoundation\Response;

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
     * UserController constructor.
     */
    public function __construct(
        UserTransformer $userTransformer,
        UserValidator $userValidator
    ) {
        $this->transformer = $userTransformer;
        $this->validator = $userValidator;
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
}
