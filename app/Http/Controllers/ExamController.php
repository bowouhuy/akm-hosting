<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ExamContract;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExamController extends BaseController
{
    protected $name = 'Exam',
        $repository,
        $redirectTo = '/exam',
        $layout = 'exam';

    public function __construct(
        ExamContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }

    public function getExamDetails($id){
        try {
            $data = Exam::with('user','package','details.question','details.answer')->findOrFail($id);

            return $this->json(
                Response::HTTP_OK,
                "Exam Fetched.",
                $data
            );
        } catch (\Exception $e) {
            throw $e;
        }
    }
}