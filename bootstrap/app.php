<?php

use App\Http\Middleware\Admin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi(); // middleware Sanctum pour authentification SPA (stateful)
        // $middleware->StartSession::class;
        // $middleware->api([
        //     \Illuminate\Session\Middleware\StartSession::class,
        //     \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //     \Illuminate\Cookie\Middleware\EncryptCookies::class,
        //     \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        //     \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        //     \App\Http\Middleware\JsonMiddleware::class,
        // ]);
        $middleware->alias([
            "admin" => Admin::class
        ]);
        // $middleware->validateCsrfTokens(except: [ // exclure des routes de la vérif CSRF (utile si erreur 419 sur routes non sanctum)
        //     'http://localhost:8000/api/login', // utile pour login car on n'a pas encore obtenu de cookie csrf 
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
