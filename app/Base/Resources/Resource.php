<?php

namespace App\Base\Resources;

use App\Core\Resources\CoreResource;

class Resource extends CoreResource
{
    public function removeNullValues(array $data): array
    {
        $filtered_data = [];
        foreach ($data as $key => $value) {
            // if resource is empty
            if ($value instanceof Resource and $value->resource === null) {
                continue;
            }
            $filtered_data[$key] = $this->when($value !== null, $value);
        }

        return $filtered_data;
    }
}
