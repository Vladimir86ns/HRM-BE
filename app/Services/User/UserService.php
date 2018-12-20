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
}
