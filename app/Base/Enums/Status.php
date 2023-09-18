<?php

declare(strict_types=1);

namespace App\Base\Enums;

/**
 * [case status]
 *
 * @var'1'|'2'|'3'|'4'
 */
enum Status: int
{
    case New = 1;
    case Work = 2;
    case Success = 3;
    case Danger = 4;
}
