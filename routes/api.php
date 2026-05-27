<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConvertedFileController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function() { // TODAS as rotas abaixo ficarão protegidas pelo middleware acima

        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        
        Route::apiResource('conversions', ConversionController::class) 
            ->only(['index', 'store', 'show', 'destroy']);
        
        Route::get('conversions/{id}/status', [ConversionController::class, 'status']); 
        Route::post('conversions/{id}/retry', [ConversionController::class, 'retry']); 
        
        Route::get('download/{id}/file', [DownloadController::class, 'download'])->name('download.arquivo');
        
        Route::apiResource('files', ConvertedFileController::class)
            ->only(['index', 'show', 'destroy']);

        Route::apiResource('profile', ProfileController::class)
            ->only(['show', 'update', 'destroy']);

        Route::apiResource('users', UserController::class);
        Route::get('users/email/{email}', [UserController::class, 'email']); 

    
    });

});
