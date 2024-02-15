<?php

declare(strict_types=1);

namespace Application\Service\User;

use Application\Constants\App;
use Core\Entities\UserEntity;
use Hyperf\Context\Context;

class UserAuthenticated
{
    public function run(): UserEntity
    {
        /** @var UserEntity */
        $user = Context::get(App::USER);

        return $user;
    }
}