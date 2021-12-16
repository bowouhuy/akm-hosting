<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class QuestionValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:questions,id' . $unique,
            'package_id' => 'required',
            'type_id' => 'required',
            'question' => 'required|string',
        ];
    }
}
