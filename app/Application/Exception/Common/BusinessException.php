<?php

declare(strict_types=1);

namespace Application\Exception\Common;

use Application\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class BusinessException extends ServerException
{
    public function __construct(int $code = 0, string $message = null, Throwable $previous = null)
    {
        parent::__construct($message ?? ErrorCode::getMessage($code), $code, $previous);
    }
}
