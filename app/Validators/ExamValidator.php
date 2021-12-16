<?php

namespace App\Validators;

use App\Validators\Contracts\ValidatorContracts;

class ExamValidator implements ValidatorContracts
{

    public static function ins()
    {
        return new self();
    }

    public function rules($id): array
    {
        $unique = $id ? ',' . $id . ',id' : '';
        return [
            'id' => 'required|string|unique:exams,id' . $unique,
            'user_id' => 'required',
            'package_id' => 'required',
            'total_question' => 'required',
            'exam_start' => 'required',
            'exam_end' => 'required',
            'status' => 'required',
            'result' => 'required',
            'score' => 'required',
        ];
    }
}
