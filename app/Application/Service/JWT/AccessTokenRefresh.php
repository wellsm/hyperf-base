<?php

declare(strict_types=1);

namespace Application\Service\JWT;

use Application\Service\User\UserAuthenticated;
use Core\Enums\TokenType;
use Psr\SimpleCache\CacheInterface;

class AccessTokenRefresh
{
    public const string ACCESS_TOKEN  = 'access-token-%d';
    public const string REFRESH_TOKEN = 'refresh-token-%d';

    public function __construct(
        private CacheInterface $cache,
        private TokenGenerate $token,
        private TokenVerify $verify,
        private UserAuthenticated $user,
    ) {}

    public function run(string $token): array
    {
        $this->verify->run($token);

        $user   = $this->user->run();
        $access = $this->token->run($user, TokenType::Access);

        $this->cache->set(sprintf(self::ACCESS_TOKEN, $user->getId()), $access);

        return [
            'access_token'  => $access,
            'refresh_token' => $token,
        ];
    }
}