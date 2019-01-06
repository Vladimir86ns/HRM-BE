<?php

namespace App\Transformers\Position;

use App\Position;
use League\Fractal\TransformerAbstract;

class PositionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Position $position
     * @return array
     */
    public function transform(Position $position)
    {
        return [
            'id' => $position->id,
            'name' => $position->name,
            'company_id' => $position->company_id,
            'department_id' => $position->department_id,
            'department_name' => $position->department->name
        ];
    }
}
