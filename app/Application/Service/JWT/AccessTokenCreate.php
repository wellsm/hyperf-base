<?php

declare(strict_types=1);

namespace Application\Service\JWT;

use Core\Entities\UserEntity;
use Core\Enums\TokenType;
use Psr\SimpleCache\CacheInterface;

class AccessTokenCreate
{
    public const string ACCESS_TOKEN  = 'access-token-%d';
    public const string REFRESH_TOKEN = 'refresh-token-%d';

    public function __construct(
        private CacheInterface $cache,
        private TokenGenerate $token,
    ) {}

    public function run(UserEntity $user): array
    {
        $access  = $this->token->run($user, TokenType::Access);
        $refresh = $this->token->run($user, TokenType::Refresh);

        $this->cache->set(sprintf(self::ACCESS_TOKEN, $user->getId()), $access);
        $this->cache->set(sprintf(self::REFRESH_TOKEN, $user->getId()), $refresh);

        return [
            'access_token'  => $access,
            'refresh_token' => $refresh,
        ];
    }
}