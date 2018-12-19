<?php

namespace App\Http\Controllers;

use App\Transformers\User\UserTransformer;
use Symfony\Component\HttpFoundation\Response;
use App\User;

class UserController extends Controller
{
    /**
     * @var \App\Transformers\User\UserTransformer
     */
    protected $transformer;

    /**
     * UserController constructor.
     */
    public function __construct(UserTransformer $userTransformer)
    {
        $this->transformer = $userTransformer;
    }

    /**
     * Get user by id.
     *
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getUser($id)
    {
        // TODO add user service to get user by id
        // TODO add validation where will validate does user exist and return user
        $user = User::find($id);

        return response(
            $this->transformer->transform($user),
            Response::HTTP_OK
        );
    }
}
