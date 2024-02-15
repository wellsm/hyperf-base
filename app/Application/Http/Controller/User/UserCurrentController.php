<?php

declare(strict_types=1);

namespace Application\Http\Controller\User;

use Application\Http\Resource\User\UserResource;
use Application\Service\User\UserAuthenticated;

class UserCurrentController
{
    public function __invoke(UserAuthenticated $service)
    {
        return new UserResource($service->run());
    }
}
