<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SubNoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('notes', NoteController::class);
Route::apiResource('subNotes', SubNoteController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('comments', CommentController::class);


