<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ResponseWithHttpStatus;
use App\Http\Controllers\Traits\CRUD;
use App\Models\Exam;
use App\Models\ExamDetail;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    use ResponseWithHttpStatus;
    use CRUD;

    public function model()
    {
        return Exam::class;
    }
    public function validationRules($resource_id = 0)
    {
        return [];
    }

    public function startExam(Request $request){
        $user_id = $request->input('user_id');
        $package_id = $request->input('package_id');
        
        $packageQuestions = Package::with('questions')->find($package_id);

        $exam = ['user_id'=>$user_id, 
                'package_id'=> $package_id,
                'total_question' => count($packageQuestions->questions),
                'exam_start' => date("H:i:s"),
                'exam_end' => date("H:i:s", strtotime('+2 hours')),
                'exam_date' => date("Y-m-d")];
        $recordExam = Exam::create($exam);

        $i=1;
        foreach($packageQuestions->questions as $q){
            $examDetails = [
                'exam_id' => $recordExam->id,
                'question_id' =>$q->id,
                'question_no' =>$i++,
            ];
        $recordExamDetails = ExamDetail::create($examDetails);
        }



        return self::trueResponse("Berhasil mengambil dataa", $recordExamDetails);
    }

    public function getExamQuestionsAnswer(Request $request){
        $user_id = $request->input('user_id');
        $exam_id = $request->input('exam_id');

        $examDetail = Exam::with('details.question.answers')->get();

        return self::trueResponse("Berhasil mengambil dataa", $examDetail);
    }

    

}
