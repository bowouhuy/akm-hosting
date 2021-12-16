<?php

namespace App\Repositories;


use App\Models\Question;
use App\Repositories\Contracts\QuestionContract;

class QuestionRepository extends Repository implements QuestionContract
{
    public function getModel()
    {
        return Question::ins();
    }

}
