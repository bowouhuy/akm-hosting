<?php

namespace App\Repositories;


use App\Models\QuestionType;
use App\Repositories\Contracts\QuestionTypeContract;

class QuestionTypeRepository extends Repository implements QuestionTypeContract
{
    public function getModel()
    {
        return QuestionType::ins();
    }

}
