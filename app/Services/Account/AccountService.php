<?php

namespace App\Services\Account;

use App\Account;
use App\User;

class AccountService
{
    /**
     * Create account, and create owner user with only password.
     *
     * @param array $attributes
     * @return Account
     */
    public function createAccountAndUserWithPassword(array $attributes)
    {
        $userAttributes = $this->getUserAttributesOnCreateAccount($attributes);
        $accountAttributes = $this->createUserAndGetAccountAttributes($userAttributes, $attributes);

        return Account::create($accountAttributes);
    }

    /**
     * Get user attributes on create account.
     *
     * @param array $attributes
     * @return array
     */
    private function getUserAttributesOnCreateAccount(array $attributes)
    {
        return [
            'first_name' => 'test',
            'last_name' => 'test',
            'password' => bcrypt($attributes['password'])
        ];
    }

    /**
     * Get account attributes.
     *
     * @param array $userAttributes
     * @param array $attributes
     * @return array
     */
    private function createUserAndGetAccountAttributes(array $userAttributes, array $attributes)
    {
        $user = User::create($userAttributes);

        return [
            'user_id' => $user->id,
            'setup_progress' => json_encode([], true),
            'password' => $userAttributes['password'],
            'name' => $attributes['name'],
            'email' => $attributes['email'],
        ];
    }
}
