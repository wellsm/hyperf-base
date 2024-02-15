<?php

declare(strict_types=1);

namespace Core\Enums;

enum TokenType: int
{
    case Access  = 60;
    case Refresh = 20160;
}