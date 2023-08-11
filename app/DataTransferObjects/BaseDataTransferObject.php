<?php

namespace App\DataTransferObjects;

use App\Exceptions\EmptyDTOException;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class BaseDataTransferObject
{
    public function toArray(): array
    {
        $propertiesArray = get_object_vars($this);
        $propertiesArray = collect($propertiesArray)->filter(fn($value) => $value !== null)->all();

        if (empty($propertiesArray)) {
            throw new EmptyDTOException(
                'The DTO has no properties to convert to array.',
                Response::HTTP_BAD_REQUEST
            );
        }

        $result = [];

        foreach ($propertiesArray as $key => $value) {
            $result[Str::snake($key)] = $value;
        }

        return $result;
    }
}