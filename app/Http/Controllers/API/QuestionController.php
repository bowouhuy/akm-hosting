<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseWithHttpStatus;
use App\Http\Controllers\Traits\CRUD;
use App\Models\Question;
use App\Models\Answer;

class QuestionController extends Controller
{
    use ResponseWithHttpStatus;
    use CRUD;

    public function model()
    {
        return Question::class;
    }
    public function validationRules($resource_id = 0)
    {
        return ['question' => 'required'];
    }

    public function getQuestionAnswers(){
        try {
            $data = Question::with('answers')->get();

            return self::trueResponse("Berhasil mengambil dataa", $data);
        } catch (\Exception $e) {
            // throw $e;
            return self::falseResponse($e->getMessage(),[],500);
        }
    }

}
