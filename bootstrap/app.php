<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'active.user' => \App\Http\Middleware\ActiveUserMiddleware::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\ActiveUserMiddleware::class,
        ]);

        $middleware->trustProxies(at: '*');

        $middleware->redirectUsersTo(function () {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ($user && $user->role === 'super_admin') return '/super-admin/dashboard';
            if ($user && $user->role === 'admin_sekolah') return '/admin/dashboard';
            if ($user && $user->role === 'guru') return '/guru/dashboard';
            if ($user && $user->role === 'siswa') return '/siswa/dashboard';
            return '/';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
