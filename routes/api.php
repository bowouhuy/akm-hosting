<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\ExamController;
use App\Http\Controllers\API\ExamDetailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|  Route Resource
|   Verb          Path                        Action  Route Name
|   GET           /users                      index   users.index
|   GET           /users/create               create  users.create
|   POST          /users                      store   users.store
|   GET           /users/{user}               show    users.show
|   GET           /users/{user}/edit          edit    users.edit
|   PUT|PATCH     /users/{user}               update  users.update
|   DELETE        /users/{user}               destroy users.destroy
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('question')->group(function(){
    Route::get('/{question_id}', [\App\Http\Controllers\QuestionController::class, 'getQuestionAnswers']);
    Route::post('/answer', [\App\Http\Controllers\QuestionController::class, 'storeAnswer']);
    Route::delete('/answer/{question_id}', [\App\Http\Controllers\QuestionController::class, 'destroyAnswer']);
});

Route::resources([
    'questions' => QuestionController::class,
    'exams' => ExamController::class,
    'examdetails' => ExamDetailController::class,
]);
Route::get('/getquestions', [QuestionController::class, 'getQuestionAnswers']);
Route::post('/startexam', [ExamController::class, 'startexam']);
Route::post('/getexamquestions', [ExamController::class, 'getExamQuestionsAnswer']);
Route::post('/storeexamasnwer/{exam_detail_id}', [ExamDetailController::class, 'storeExamAnswer']);
