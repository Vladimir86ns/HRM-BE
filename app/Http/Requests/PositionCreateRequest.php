<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionCreateRequest extends FormRequest
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
            'positions.*.names' => 'required',
            'positions.*.names.*' => 'required|min:1',
            'positions.*.department_name' => 'required|exists:departments,name',
            'positions.*.company_name' => 'required|exists:companies,name',
            'positions.*.department_id' => 'required|exists:departments,id',
            'positions.*.company_id' => 'required|exists:companies,id',

            'company_id' => 'required',
            'account_id' => 'required',
        ];
    }
}
