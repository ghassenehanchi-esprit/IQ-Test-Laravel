<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then:function () {
            Route::middleware('web')
                ->namespace('App\\Http\\Controllers\\Admin') // Adjusted namespace
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin.guest' => \App\Http\Middleware\RedirectIfAdmin::class,
            'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
            'checkQuizOwner' => \App\Http\Middleware\CheckQuizOwner::class,
            'verify.stripe.payment'=>\App\Http\Middleware\VerifyStripePayment::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
