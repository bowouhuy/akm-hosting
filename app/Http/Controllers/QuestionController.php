<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\QuestionContract;
use App\Models\Question;
use App\Models\Answer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class QuestionController extends BaseController
{
    protected $name = 'Question',
        $repository,
        $redirectTo = '/question',
        $layout = 'question';

    public function __construct(
        QuestionContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }

    public function fetchCustomDatatable(){
        try {
            $list = Question::with('package','type')->get()->toArray();
            
            $dt = Datatables::collection($list)
                ->toArray();
            
            $json = preg_replace('/{"EMPTY_OBJECT"\s*:\s*true}/',
                '{}',
                json_encode($dt, JSON_UNESCAPED_SLASHES));
            
            return $json;

        } catch (\Exception $e) {
            return back()
                ->withErrors(
                    $e->__toString()
                );
        }
    }

    public function getQuestionAnswers($id){
        try {
            $data = Question::with('answers')->findOrFail($id);

            return $this->json(
                Response::HTTP_OK,
                "Answer Fetched.",
                $data
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function storeAnswer(Request $request){
        try {
            $data = Answer::create($request->all());

            return $this->json(
                Response::HTTP_CREATED,
                "Saved Successfully.",
                $data
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroyAnswer($id, Request $request){
        try {
            $data = Answer::where('question_id','=', $id);

            if ($data->delete())
                return $this->json(
                    Response::HTTP_OK,
                    "The Answers $id was deleted."
                );
        } catch (\Exception $e) {
            if ($request->expectsJson())
                throw $e;
        }
    }
}