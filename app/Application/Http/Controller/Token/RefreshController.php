<?php

declare(strict_types=1);

namespace Application\Http\Controller\Token;

use Application\Constants\App;
use Application\Http\Resource\User\UserAuthResource;
use Application\Service\JWT\AccessTokenRefresh;
use Hyperf\HttpServer\Request;
use Hyperf\Stringable\Str;

class RefreshController
{
    public function __invoke(Request $request, AccessTokenRefresh $service)
    {
        $token = $request->getHeaderLine(App::JWT_HEADER);
        $token = trim(Str::after($token, 'Bearer'));

        return new UserAuthResource(
            $service->run($token)
        );
    }
}
