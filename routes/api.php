<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::post('singin', [AuthController::class, 'singIn']);
Route::middleware(['auth:api','throttle:3,1'])->group(function () {
    Route::prefix('files')->group(function () {
        Route::get('/', [FileController::class, 'list']);
        Route::post('/', [FileController::class, 'store']);
        Route::delete('/{id}', [FileController::class, 'destroy'])->where(['id' => '[0-9]+']);
        Route::delete('/{id}', [FileController::class, 'forceDestroy'])->where(['id' => '[0-9]+']);
        Route::delete('/{id}/force', [FileController::class, 'forceDestroy'])->where(['id' => '[0-9]+']);
    });
});
