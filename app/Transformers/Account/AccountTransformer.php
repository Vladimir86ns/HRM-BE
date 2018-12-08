<?php

namespace App\Transformers\Account;

use App\Account;
use League\Fractal\TransformerAbstract;

class AccountTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Account $account
     * @return array
     */
    public function transform(Account $account)
    {
        return [
            'id' => $account->id,
            'name' => $account->name,
            'email' => $account->email
        ];
    }
}
