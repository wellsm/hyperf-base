<?php

declare(strict_types=1);

return [
    Core\Repositories\UserRepository::class => Infrastructure\Repositories\UserDatabaseRepository::class,
];
