<?php

declare(strict_types=1);

namespace Core\Repositories;

use Core\Entities\UserEntity;
use Core\ValueObject\EmailValueObject;

interface UserRepository
{
    public function getUserById(int $id): ?UserEntity;

    public function getUserByEmail(EmailValueObject $email): ?UserEntity;
}
