<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\UserChecks;
use App\Http\Middleware\SoftMaintenance;
use App\Http\Middleware\FeatureStatus;

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
        // overwrite soft errors with redirects instead
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\PaymentRequiredHttpException $e, $request) {
            return redirect('/402');
        });
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return redirect('/404');
        });
        $exceptions->renderable(function (\Symfony\Component\HttpKernel\Exception\TokenMismatchException $e, $request) {
            return redirect('/419');
        });
    })->create();
