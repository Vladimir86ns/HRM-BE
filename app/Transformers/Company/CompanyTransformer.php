<?php

namespace App\Transformers\Company;

use App\Company;
use App\Transformers\Account\DepartmentTransformer;
use App\Transformers\Locaton\LocationTransformer;
use League\Fractal\TransformerAbstract;

class CompanyTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'location', 'departments'
    ];

    /**
     * A Fractal transformer.
     *
     * @param Company $company
     * @return array
     */
    public function transform(Company $company)
    {
        return [
            'id' => $company->id,
            'name' => $company->name,
            'email' => $company->email,
            'website' => $company->website,
            'mobile_phone' => $company->mobile_phone,
            'telephone_number' => $company->telephone_number,
            'fax_number' => $company->fax_number
        ];
    }

    /**
     * Include Location
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeLocation(Company $company)
    {
        $location = $company->location;
        if ($location) {
            return $this->item($location, new LocationTransformer(), 'withoutDataKey');
        }
    }

    /**
     * Include Departments
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeDepartments(Company $company)
    {
        $departments = $company->departments;
        if ($departments) {
            return $this->collection($departments, new DepartmentTransformer(), 'withoutDataKey');
        }
    }
}
