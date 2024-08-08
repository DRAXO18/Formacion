<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use App\Http\Middleware\CheckAcceso;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // \App\Http\Middleware\CheckAcceso::class;
        // $middleware->append(CheckAcceso::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
