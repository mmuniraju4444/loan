<?php

use App\Http\Middleware\ApproverUserOnly;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/health', function () {
    return response()->json([
        'status' => 'SUCCESS'
    ]);
});

Route::post('register', 'AuthController@registerApplicant');
Route::post('register-approver', 'AuthController@registerApprover');
Route::post('login', 'AuthController@login');


Route::middleware('auth:api')->group(function () {

    Route::middleware(ApproverUserOnly::class)->group(function () {
        Route::post('loan-applications/{uuid}/status', 'LoanController@status');
    });

    Route::resource('loan-applications', 'LoanController');
    Route::resource('loan-interests', 'LoanInterestController');
    Route::resource('loan-types', 'LoanTypeController');
    Route::resource('repayment-types', 'RepaymentTypeController');

    Route::post('loan-applications/{uuid}/repayment', 'LoanRepaymentController@store');
    Route::get('loan-repayments/{uuid}', 'LoanRepaymentController@show');


});
