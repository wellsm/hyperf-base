<?php

declare(strict_types=1);

namespace Application\Service\User;

use Application\Exception\Common\BusinessException;
use Application\Service\JWT\AccessTokenCreate;
use Core\DTO\User\UserAuthDTO;
use Core\Repositories\UserRepository;
use Teapot\StatusCode\Http;

class UserAuth
{
    public function __construct(
        private UserRepository $repository,
        private AccessTokenCreate $token,
    ) {}

    public function run(UserAuthDTO $dto): array
    {
        $user = $this->repository->getUserByEmail($dto->getEmail());

        if (empty($user->getPassword())) {
            throw new BusinessException(Http::NOT_FOUND);
        }

        $pass = $user->getPassword()->check($dto->getPassword());

        if ($pass === false) {
            throw new BusinessException(Http::NOT_FOUND);
        }

        return $this->token->run($user);
    }
}