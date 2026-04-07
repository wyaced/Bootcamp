<?php

use App\Http\Middleware\CheckRole;
use App\Http\Middleware\NotDeleted;
use App\Http\Middleware\NotMuted;
use App\Http\Middleware\NotRedacted;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => CheckRole::class,
            'not_muted' => NotMuted::class,
            'not_redacted' => NotRedacted::class,
            'not_deleted' => NotDeleted::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
