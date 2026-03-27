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
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    /*Route::middleware('auth:sanctum')->group(function() { // TODAS as rotas abaixo ficarão protegidas pelo middleware acima*/

        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        
        Route::apiResource('conversions', ConversionController::class) // Rota de converssões
            ->only(['index', 'store', 'show', 'destroy']);
        
        Route::get('conversions/{id}/status', [ConversionController::class, 'status']); // Mostra o status da conversão
        Route::post('conversions/{id}/retry', [ConversionController::class, 'retry']); // Tenta refazer a conversão caso falhe
        
        Route::get('download/{id}', [DownloadController::class, 'download']); // Rota para fazer o Download com ID do arquivo
        
        Route::apiResource('files', ConvertedFileController::class) // Rota para os arquivos convertidos
            ->only(['index', 'show', 'delete']);


        //rotas perfil do usuário
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::delete('/profile', [ProfileController::class, 'destroy']);

        //rotas users
        Route::apiResource('users', UserController::class);
        
    //});

});
