<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** FETCH DATATABLES */
// Route::get('question/datatable', [\App\Http\Controllers\QuestionController::class, 'fetchDatatable']);
Route::get('question/datatable', [\App\Http\Controllers\QuestionController::class, 'fetchCustomDatatable']);
Route::get('package/datatable', [\App\Http\Controllers\PackageController::class, 'fetchDatatable']);
Route::get('question_type/datatable', [\App\Http\Controllers\QuestionTypeController::class, 'fetchDatatable']);
Route::get('participant/datatable', [\App\Http\Controllers\UserController::class, 'fetchDatatable']);
Route::get('wallet/datatable', [\App\Http\Controllers\WalletController::class, 'fetchCustomDatatable']);
Route::get('transaction/datatable', [\App\Http\Controllers\TransactionController::class, 'fetchCustomDatatable']);
Route::get('exam/datatable', [\App\Http\Controllers\ExamController::class, 'fetchDatatable']);

/** GET LIST */
Route::get('wallet/list/{wallet_id}', [\App\Http\Controllers\WalletController::class, 'getWalletDetails']);
Route::get('package/list', [\App\Http\Controllers\PackageController::class, 'list']);
Route::get('question_types/list', [\App\Http\Controllers\QuestionTypeController::class, 'list']);
Route::get('question/list/{question_id}', [\App\Http\Controllers\QuestionController::class, 'getQuestionAnswers']);
Route::get('exam/list/{exam_id}', [\App\Http\Controllers\ExamController::class, 'getExamDetails']);

/** etc */
Route::post('answer', [\App\Http\Controllers\QuestionController::class, 'storeAnswer']);
Route::delete('answer/{question_id}', [\App\Http\Controllers\QuestionController::class, 'destroyAnswer']);

/** CORE MENU */
Route::resources([
    'dashboard' => \App\Http\Controllers\DashboardController::class,
    'question' => \App\Http\Controllers\QuestionController::class,
    'package' => \App\Http\Controllers\PackageController::class,
    'question_type' => \App\Http\Controllers\QuestionTypeController::class,
    'participant' => \App\Http\Controllers\UserController::class,
    'wallet' => \App\Http\Controllers\WalletController::class,
    'transaction' => \App\Http\Controllers\TransactionController::class,
    'exam' => \App\Http\Controllers\ExamController::class,
]);

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);