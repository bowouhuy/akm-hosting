<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\QuestionTypeContract;
use Illuminate\Http\Request;

class QuestionTypeController extends BaseController
{
    protected $name = 'Question Type',
        $repository,
        $redirectTo = '/question_type',
        $layout = 'question_type';

    public function __construct(
        QuestionTypeContract $contract)
    {
        $this->middleware('auth.admin');
        $this->repository = $contract;
    }
}