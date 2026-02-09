<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middlewares\CheckRole;
use App\Http\Middlewares\AdminMiddleware;
use App\Http\Middlewares\PetugasMiddleware;
use App\Http\Middlewares\SiswaMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => CheckRole::class,
            'admin' => AdminMiddleware::class,
            'petugas' => PetugasMiddleware::class,
            'siswa' => SiswaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();