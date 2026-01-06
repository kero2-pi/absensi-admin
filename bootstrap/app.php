<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    

->withExceptions(function (Exceptions $exceptions) {

    // SESSION / LOGIN HABIS
    $exceptions->render(function (AuthenticationException $e, $request) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        return redirect()->route('login');
    });

    // CSRF TOKEN EXPIRED
    $exceptions->render(function (TokenMismatchException $e, $request) {
        auth()->guard('web')->logout();
;

        return redirect()
            ->route('login')
            ->with('message', 'Session habis, silakan login ulang');
    });

})
->create();
