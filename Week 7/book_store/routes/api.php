<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Author\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PaymentsController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('books', BookController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('payments', PaymentsController::class);
