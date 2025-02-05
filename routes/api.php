<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TranslationController;
use App\Http\Controllers\Api\RegisterController;

Route::controller(RegisterController::class)->group(function(){
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/translations', [TranslationController::class, 'store']);
    Route::put('/translations/{translation}', [TranslationController::class, 'update']);
    Route::get('/translations/{translation}', [TranslationController::class, 'show']);
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::get('/export', [TranslationController::class, 'export']);
});
