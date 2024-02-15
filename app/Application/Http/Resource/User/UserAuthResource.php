<?php

declare(strict_types=1);

namespace Application\Http\Resource\User;

use Core\Enums\TokenType;
use Hyperf\Resource\Json\JsonResource;

class UserAuthResource extends JsonResource
{
    public ?string $wrap = null;

    public function toArray(): array
    {
        return array_merge([
            'expires_in' => TokenType::Access->value * 60,
            'type'       => 'Bearer'
        ], $this->resource);
    }
}
