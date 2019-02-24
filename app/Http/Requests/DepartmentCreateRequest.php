<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentCreateRequest extends FormRequest
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
            'departments' => 'required',
            'company_id' => 'required',
            'account_id' => 'required|exists:accounts,id',

            'departments.*.name' => 'required',
            'departments.*.description' => 'string|max:200',
            'departments.*.company_name' => 'required|exists:companies,name',
            'departments.*.company_id' => 'required|exists:companies,id',
        ];
    }
}

