<?php

declare(strict_types=1);

namespace Application\Service\JWT;

use Application\Constants\ErrorCode;
use Application\Exception\Common\BusinessException;
use Core\Entities\UserEntity;
use Core\Enums\TokenType;
use Firebase\JWT\JWT;
use Hyperf\Contract\ConfigInterface;

class TokenGenerate
{
    public function __construct(
        private ConfigInterface $config,
    ) {}

    public function run(UserEntity $user, TokenType $type): string
    {
        $key = $this->config->get('app_key');

        if (empty($key)) {
            throw new BusinessException(ErrorCode::APP_KEY_UNDEFINED);
        }

        return JWT::encode([
            'iss'  => (string) $user->getEmail(),
            'name' => $user->getName(),
            'sub'  => $user->getId(),
            'iat'  => time(),
            'exp'  => strtotime("+{$type->value} minute", time()),
        ], $key, 'HS256');
    }
}