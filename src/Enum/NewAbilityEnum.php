<?php

declare(strict_types=1);

namespace App\Enum;

enum NewAbilityEnum: string
{
    case STR = 'str';
    case DEX = 'dex';
    case CON = 'con';
    case INT = 'int';
    case WIS = 'wis';
    case CHA = 'cha';
}