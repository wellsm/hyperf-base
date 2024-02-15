<?php

declare(strict_types=1);

use Application\Constants\Env;
use Hyperf\Contract\StdoutLoggerInterface;
use Psr\Log\LogLevel;

use function Hyperf\Support\env;

return [
    'app_name'                   => env('APP_NAME'),
    'app_env'                    => env('APP_ENV'),
    'app_key'                    => env('APP_KEY'),
    'scan_cacheable'             => env('SCAN_CACHEABLE', false),
    StdoutLoggerInterface::class => [
        'log_level' => array_merge([
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::EMERGENCY,
            LogLevel::ERROR,
            LogLevel::INFO,
            LogLevel::NOTICE,
            LogLevel::WARNING,
        ], Env::ifLocal([
            LogLevel::DEBUG
        ], [])),
    ],
];
