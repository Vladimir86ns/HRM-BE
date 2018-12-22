<?php

namespace App\Services\User;

use App\User;

class UserService
{
    public function createUser()
    {
        //
    }

    /**
     * Get user by id.
     *
     * @param int $id
     * @return mixed
     */
    public function getUserById(int $id)
    {
        return User::find($id);
    }

    /**
     * Update user info
     *
     * @param User  $user
     * @param array $attributes
     *
     * @return User
     */
    public function updateUser(User $user, array $attributes)
    {
        $user->userInfo->update($attributes);
        return $user;
    }
}
