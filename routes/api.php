<?php

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

use App\Http\Controllers\TranslationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/translations', [TranslationController::class, 'index']);
    Route::post('/store', [TranslationController::class, 'store']);
    Route::put('/update/{translation}', [TranslationController::class, 'update']);
    Route::get('/translations/export/{locale}', [TranslationController::class, 'export']);
});
