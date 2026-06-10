<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConvertedFileController;

/*
|--------------------------------------------------------------------------
| Auth user route (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);

        Route::apiResource('conversions', ConversionController::class)
            ->only(['index', 'store', 'show', 'destroy']);

        Route::get('conversions/{id}/status', [ConversionController::class, 'status']);
        Route::post('conversions/{id}/retry', [ConversionController::class, 'retry']);

        Route::get('download/{id}/file', [DownloadController::class, 'download'])
            ->name('download.arquivo');

        Route::apiResource('files', ConvertedFileController::class)
            ->only(['index', 'show', 'destroy']);


        Route::middleware('admin')->group(function () {

            Route::apiResource('users', UserController::class);
            Route::get('users/email/{email}', [UserController::class, 'email']);
            Route::get('admin', [UserController::class, 'admins']);

        });

    });

});