<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
{
    // ENSINA O SANCTUM A PROCURAR O TOKEN TAMBÉM NA URL (?token=...)
    Sanctum::getAccessTokenFromRequestUsing(function (Request $request) {
        // 1. Primeiro ele tenta o método padrão: procurar no Header
        if ($token = $request->bearerToken()) {
            return $token;
        }

        // 2. Se não achar no header, ele "pesca" o parâmetro 'token' da URL
        if ($request->has('token')) {
            return str_replace('Bearer ', '', $request->query('token'));
        }

        return null;
    });
}
}
