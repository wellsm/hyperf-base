<?php

declare(strict_types=1);

use Core\Helper\Util;

return [
    'locale'          => Util::DEFAULT_LOCALE,
    'fallback_locale' => Util::LOCALE_EN_US,
    'path'            => BASE_PATH . '/storage/languages',
];
