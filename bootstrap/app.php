<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware)
    {

        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\Localization::class
        ]);


        $middleware->alias([
            'auth' => 'Illuminate\Auth\Middleware\Authenticate',
            'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
            'auth.session' => 'Illuminate\Session\Middleware\AuthenticateSession',
            'cache.headers' => 'Illuminate\Http\Middleware\SetCacheHeaders',
            'can' => 'Illuminate\Auth\Middleware\Authorize',
            'guest' => 'Illuminate\Auth\Middleware\RedirectIfAuthenticated',
            'password.confirm' => 'Illuminate\Auth\Middleware\RequirePassword',
            'precognitive' => 'Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests',
            'signed' => 'Illuminate\Routing\Middleware\ValidateSignature',
            'verified' => 'Illuminate\Auth\Middleware\EnsureEmailIsVerified',
            'default_product_exists' => \App\Http\Middleware\CheckDefaultProductExist::class,
            'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'vendor_settings' => \App\Http\Middleware\VendorSettingMiddleware::class,
            'front_setting_middleware' => \App\Http\Middleware\FrontMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions)
    {
        //
    })->create();
