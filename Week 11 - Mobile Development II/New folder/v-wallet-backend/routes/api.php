<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransfersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BeneficiaryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
Route::post('/generate-qr', [TransfersController::class, 'generateQr']);
Route::post('/transfers-phone', [TransfersController::class, 'phoneTransfers']);
Route::post('/transfers-qr', [TransfersController::class, 'QrTransfers']);
Route::get('/getTransferHistory', [TransfersController::class, 'getHistory']);
Route::get('/filterTransferHistory', [TransfersController::class, 'filterHistory']);

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/beneficiaries', [BeneficiaryController::class, 'index']);
    Route::post('/beneficiaries', [BeneficiaryController::class, 'store']);
    Route::delete('/beneficiaries/{beneficiaryId}', [BeneficiaryController::class, 'destroy']);

    });

    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

