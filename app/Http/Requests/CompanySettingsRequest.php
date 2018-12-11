<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanySettingsRequest extends FormRequest
{
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
        return [
            'account_info' => 'required',
            'account_info.name' => 'required|min:3|max:100',
            'account_info.email' => 'required|unique:accounts,email|email|max:100,',
            'account_info.account_id' => 'required|integer|min:1|max:100,',

            'company_info' => 'required',

            'company_info.*.company' => 'required',
            'company_info.*.company.name' => 'required|min:3|max:100',
            'company_info.*.company.email' => 'email|max:150,',
            'company_info.*.company.website' => 'max:200',
            'company_info.*.company.mobile_phone' => 'max:50',
            'company_info.*.company.telephone_number' => 'max:50',
            'company_info.*.company.fax_number' => 'max:100,',

            'company_info.*.location' => 'required',
            'company_info.*.location.country_id' => 'required|min:3|max:100',
            'company_info.*.location.region' => 'max:100',
            'company_info.*.location.city' => 'max:100',
            'company_info.*.location.zip_code' => 'numeric|min:1|max:100000',
            'company_info.*.location.first_address_line' => 'max:100',
            'company_info.*.location.second_address_line' => 'max:100',

            'company_info.*.department_info' => 'required',
            'company_info.*.department_info.*.name' => 'required|min:3|max:50',
            'company_info.*.department_info.*.description' => 'max:100',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'account_info.name.required' => 'Account name is required!',
            'account_info.email.required'  => 'Account email is required!',
            'account_info.email.email'  => 'The account email must be a valid email address.',
            'account_info.email.unique'  => 'The account email has already been taken.',
            'account_info.email.max'  => "The account email may not be greater than 150 characters.",
        ];
    }
}
