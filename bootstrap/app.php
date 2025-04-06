<?php

use App\Http\Middleware\RedirectIfHasPower;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'power' => UserMiddleware::class,
            'no_power' => RedirectIfHasPower::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
