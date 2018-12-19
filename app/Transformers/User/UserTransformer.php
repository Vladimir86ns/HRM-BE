<?php

namespace App\Transformers\User;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->userInfo->first_name,
            'middle_name' => $user->userInfo->middle_name ?? '',
            'last_name' => $user->userInfo->last_name,
            'email' => $user->userInfo->email ?? '',
            'gender' => $user->userInfo->gender ?? '',
            'status' => $user->status,
            'user_type' => $user->user_type
        ];
    }
}
