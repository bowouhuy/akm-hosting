<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\CRUD;
use App\Http\Controllers\Traits\ResponseWithHttpStatus;
use App\Models\ExamDetail;

class ExamDetailController extends Controller
{
    use CRUD;
    use ResponseWithHttpStatus;

    public function model()
    {
        return ExamDetail::class;
    }
    public function validationRules($resource_id = 0)
    {
        return ['question' => 'required'];
    }

    public function storeExamAnswer(Request $request, $id){

        $keyStatus =

        $data = [
            'answer_id' => $request->anser_id,
            'answer_status' => 1,
            'answer_key' =>
        ]

        return self::trueResponse("Berhasil mengambil dataa", "hehe");
    }
}
