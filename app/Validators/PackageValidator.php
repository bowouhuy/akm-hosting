<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class PackageValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:packages,id' . $unique,
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required',
        ];
    }
}
