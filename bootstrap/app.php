<?php

use App\Http\Middleware\CustomerMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'auth'])
                ->prefix('/admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
            Route::middleware(['web'])
                ->prefix('/customer')
                ->name('customer.')
                ->group(base_path('routes/customer.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'isCustomer' => CustomerMiddleware::class
        ]);

        $middleware->validateCsrfTokens(except: [
            '/success',
            '/cancel',
            '/fail',
            '/ipn',
            '/pay-via-ajax',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
