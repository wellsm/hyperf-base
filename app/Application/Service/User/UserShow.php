<?php

declare(strict_types=1);

namespace Application\Service\User;

use Core\Entities\UserEntity;
use Core\Repositories\UserRepository;

class UserShow
{
    public function __construct(
        private UserRepository $repository,
    ) {}

    public function run(int $id): UserEntity
    {
        return $this->repository->getUserById($id);
    }
}