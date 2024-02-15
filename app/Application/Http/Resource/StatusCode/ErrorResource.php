<?php

declare(strict_types=1);

namespace Application\Http\Resource\StatusCode;

use Application\Constants\ErrorCode;
use Hyperf\Resource\Json\JsonResource;
use Hyperf\Resource\Response\Response;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\Http;
use Exception;
use Hyperf\Database\Model\ModelNotFoundException;
use Hyperf\Validation\ValidationException;

class ErrorResource extends JsonResource
{
    /** @var Exception */
    public mixed $resource;
    public ?string $wrap = null;

    public function toArray(): array
    {
        $code    = $this->resource->getCode();
        $message = ErrorCode::getMessage($code);
 
        return [
            'code'    => $code,
            'message' => $message,
        ];
    }

    public function toResponse(): ResponseInterface
    {
        if ($this->resource instanceof ModelNotFoundException) {
            return (new NotFoundResource(0))->toResponse();
        }

        if ($this->resource instanceof ValidationException) {
            return (new ValidationResource(0))->toResponse();
        }

        $status = match ($this->resource->getCode()) {
            Http::NOT_FOUND    => Http::NOT_FOUND,
            Http::BAD_REQUEST  => Http::BAD_REQUEST,
            Http::UNAUTHORIZED => Http::UNAUTHORIZED,
            Http::FORBIDDEN    => Http::FORBIDDEN,
            default            => Http::INTERNAL_SERVER_ERROR,
        };

        return (new Response($this))
            ->toResponse()
            ->withStatus($status);
    }
}
