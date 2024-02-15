<?php

declare(strict_types=1);

namespace Application\Http\Resource\StatusCode;

use Application\Exception\BusinessException;
use Hyperf\Resource\Json\JsonResource;
use Hyperf\Resource\Response\Response;
use Hyperf\Validation\Validator;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\All as Http;

class ValidationResource extends JsonResource
{
    /** @var BusinessException */
    public mixed $resource;
    public ?string $wrap = null;

    public function toArray(): array
    {
        /** @var Validator */
        $validator = $this->resource->validator;

        return [
            'code'   => Http::UNPROCESSABLE_ENTITY,
            'errors' => $validator->errors()->getMessages(),
        ];
    }

    public function toResponse(): ResponseInterface
    {
        return (new Response($this))
            ->toResponse()
            ->withStatus(Http::UNPROCESSABLE_ENTITY);
    }
}
