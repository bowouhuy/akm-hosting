<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Repositories\Contracts\ExamContract;

class ExamRepository extends Repository implements ExamContract
{
    public function getModel()
    {
        return Exam::ins();
    }

}
