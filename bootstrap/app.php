<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\ShareUserData;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware aliases
        $middleware->alias([
            'admin.auth' => AdminAuth::class,
        ]);
        
        // Register global middleware (akan dijalankan di semua request)
        $middleware->append(ShareUserData::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
