<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserStatus;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\ValidateSignature;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\AuthenticateWithBasicAuth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'user.status' => UserStatus::class,
            'isadmin' => IsAdmin::class,
            'signed' => ValidateSignature::class,
            'guest' => RedirectIfAuthenticated::class,
            'auth' => Authenticate::class,
            'auth.basic' => AuthenticateWithBasicAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
