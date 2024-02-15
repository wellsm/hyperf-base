<?php

declare(strict_types=1);

namespace Infrastructure\Repositories;

use App\Model\User;
use Core\Entities\UserEntity;
use Core\Repositories\UserRepository;
use Core\ValueObject\EmailValueObject;

class UserDatabaseRepository implements UserRepository
{
    public function getUserById(int $id): ?UserEntity
    {
        return User::findFromCache($id);
    }

    public function getUserByEmail(EmailValueObject $email): ?UserEntity
    {
        return User::where('email', (string) $email)->first();
    }
}
