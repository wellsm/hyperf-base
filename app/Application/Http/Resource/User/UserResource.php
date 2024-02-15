<?php

declare(strict_types=1);

namespace Application\Http\Resource\User;

use Core\Entities\UserEntity;
use Hyperf\Resource\Json\JsonResource;

class UserResource extends JsonResource
{
    /** @var UserEntity */
    public mixed $resource;

    public ?string $wrap = null;

    public function toArray(): array
    {
        return [
            'id'    => $this->resource->getId(),
            'name'  => $this->resource->getName(),
            'email' => (string) $this->resource->getEmail(),
        ];
    }
}
