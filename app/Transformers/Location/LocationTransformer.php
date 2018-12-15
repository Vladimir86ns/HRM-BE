<?php

namespace App\Transformers\Locaton;

use App\Location;
use League\Fractal\TransformerAbstract;

class LocationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Location $location
     * @return array
     */
    public function transform(Location $location)
    {
        return [
            'id' => $location->id,
            'country' => $location->country,
            'region' => $location->region,
            'city' => $location->city,
            'zip_code' => $location->zip_code,
            'first_address_line' => $location->first_address_line,
            'second_address_line' => $location->second_address_line,
            'is_headquarters' => $location->is_headquarters
        ];
    }
}
