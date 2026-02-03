<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LoanCollectionController;
use App\Http\Controllers\Api\LoanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user', [AuthController::class, 'user']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('customers', [CustomerController::class, 'customerList']);
    Route::post('customer-create', [CustomerController::class, 'customerCreate']);
    Route::post('customer-update', [CustomerController::class, 'customerUpdate']);
    Route::get('customer-details', [CustomerController::class, 'customerDetails']);
    Route::delete('customer-delete', [CustomerController::class, 'customersDelete']);

    Route::get('loans', [LoanController::class, 'loanList']);
    Route::post('loan-create', [LoanController::class, 'loanCreate']);
    Route::post('loan-update', [LoanController::class, 'loanUpdate']);
    Route::get('loan-details', [LoanController::class, 'loanDetails']);
    Route::delete('loan-delete', [LoanController::class, 'loanDelete']);

    Route::get('loan-collections', [LoanCollectionController::class, 'loanCollectionList']);
    Route::post('loan-collection-create', [LoanCollectionController::class, 'loanCollectionCreate']);
    Route::post('loan-collection-update', [LoanCollectionController::class, 'loanCollectionUpdate']);
    Route::get('loan-collection-details', [LoanCollectionController::class, 'loanCollectionDetails']);
    Route::delete('loan-collection-delete', [LoanCollectionController::class, 'loanCollectionDelete']);
});
