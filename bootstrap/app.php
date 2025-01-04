<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\UserChecks;
use App\Http\Middleware\FeatureStatus;
use App\Http\Middleware\SoftMaintenance;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // soft maintenance takes priority
        $middleware->web(append: [SoftMaintenance::class, UserChecks::class, FeatureStatus::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
