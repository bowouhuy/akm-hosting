<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class QuestionTypeValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:question_types,id' . $unique,
            'name' => 'required|string',
        ];
    }
}
