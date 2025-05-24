<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ModeratorOrAdmin;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\VerifiedOrAdmin;
use Biscolab\ReCaptcha\Middleware\ReCaptchaMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withProviders()
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'verified_or_admin' => VerifiedOrAdmin::class,
            'moderator_or_admin' => ModeratorOrAdmin::class,
            'admin' => AdminMiddleware::class,
            'role' => RoleMiddleware::class,
            'recaptcha' => ReCaptchaMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();
