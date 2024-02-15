<?php

declare(strict_types=1);

namespace Application\Service\JWT;

use Application\Constants\App;
use Application\Constants\ErrorCode;
use Application\Exception\Common\BusinessException;
use Application\Service\User\UserShow;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Hyperf\Context\Context;
use Hyperf\Contract\ConfigInterface;
use Teapot\StatusCode\Http;

class TokenVerify
{
    public function __construct(
        private UserShow $user,
        private ConfigInterface $config,
    ) {}

    public function run(?string $token): void
    {
        if (empty($token)) {
            throw new BusinessException(Http::UNAUTHORIZED);
        }

        $key = $this->config->get('app_key');

        if (empty($key)) {
            throw new BusinessException(ErrorCode::APP_KEY_UNDEFINED);
        }

        try {
            $jwt = JWT::decode($token, new Key($key, 'HS256'));
        } catch (Exception) {
            throw new BusinessException(Http::FORBIDDEN);
        }

        /** @var User */
        $user = $this->user->run($jwt->sub);

        Context::set(App::USER, $user);
    }
}