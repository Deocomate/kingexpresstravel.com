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
    ->withMiddleware(function (Middleware $middleware) {
        // Vô hiệu hóa CSRF của Laravel cho các route của CKFinder
        $middleware->validateCsrfTokens(except: [
            'ckfinder/*', // Thêm đường dẫn của CKFinder vào đây
        ]);

        // Ngăn Laravel mã hóa cookie ckCsrfToken của CKFinder
        $middleware->encryptCookies(except: [
            'ckCsrfToken',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
