<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserProfileUpdateRequest extends FormRequest
{
    public $attributes;

    /**
     * UserProfileUpdateRequest constructor.
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userInfoDetailId = $this->attributes['user_info_detail_id'];

        return [
            'account_id' => 'required|integer',
            'first_name' => 'required|string|min:2|max:100',
            'middle_name' => 'string|min:2|max:100',
            'last_name' => 'required|string|min:2|max:100',
            'email' => 'required|unique:user_info_details,email,' . $userInfoDetailId . '|email|max:100,',
            'gender' => 'string|in:' . implode(',', User::USER_GENDER_TYPES) . '|nullable'
        ];
    }
}
