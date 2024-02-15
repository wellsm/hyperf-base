<?php

declare(strict_types=1);

use Hyperf\HttpServer\Router\Router;
use Application\Http\Controller;
use Application\Http\Middleware;

Router::addGroup('/api', function () {
    Router::get('/documentation', Controller\Documentation\IndexController::class);

    Router::post('/auth', Controller\User\UserAuthController::class);

    Router::addGroup('', function () {
        Router::get('/me', Controller\User\UserCurrentController::class);
        Router::post('/token/refresh', Controller\Token\RefreshController::class);
    }, [
        'middleware' => [
            Middleware\VerifyJWTMiddleware::class
        ]
    ]);
});
