<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('loan_applications', App\Http\Controllers\API\LoanApplicationAPIController::class);


//auth routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [App\Http\Controllers\API\UserAPIController::class, 'createNewAccount']);
    Route::post('/login', [App\Http\Controllers\API\UserAPIController::class, 'login']);

});

//loana pplication routes
Route::prefix('loans')->middleware('auth:sanctum')->group(function () {
    Route::post('apply', [App\Http\Controllers\API\LoanApplicationAPIController::class, 'apply']);
    Route::get('{loanId}', [App\Http\Controllers\API\LoanApplicationAPIController::class, 'showLoanStatus']);
    Route::put('{loanId}', [App\Http\Controllers\API\LoanApplicationAPIController::class, 'updateLoan']);
    Route::get('customer/{customerId}', [App\Http\Controllers\API\LoanApplicationAPIController::class, 'customerLoanApplications']);

});

