<?php

declare(strict_types=1);

namespace Application\Http\Middleware;

use Application\Constants\App;
use Application\Service\JWT\TokenVerify;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Stringable\Str;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VerifyJWTMiddleware implements MiddlewareInterface
{
    #[Inject()]
    private TokenVerify $verify;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $query  = $request->getQueryParams();
        $bearer = $query[App::JWT_HEADER] ?? $request->getHeaderLine(App::JWT_HEADER);
        $bearer = trim(Str::after($bearer, 'Bearer'));

        $this->verify->run($bearer);

        return $handler->handle($request);
    }
}
