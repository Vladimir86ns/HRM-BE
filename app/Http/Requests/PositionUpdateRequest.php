<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class PositionUpdateRequest extends FormRequest
{
    public $companyId;
    public $positionId;
    public $departmentId;

    /**
     * PositionUpdateRequest constructor.
     *
     * @param string $companyId Company ID
     * @param string $positionId Position ID
     * @param int $departmentId Department ID
     */
    public function __construct(string $companyId, string $positionId, int $departmentId)
    {
        $this->companyId = $companyId;
        $this->positionid = $positionId;
        $this->departmentId = $departmentId;
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
        return [
            'name' => [
                'required',
                'min:1',
                'max:100',
                ValidationRule::unique('positions', 'name')
                    ->where(function ($query) {
                        $query->where('id', '<>', $this->positionid)
                            ->where('company_id', $this->companyId)
                            ->where('department_id', $this->departmentId);
                    })
            ]
        ];
    }
}
