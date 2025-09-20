<?php

declare(strict_types=1);

namespace App\Enum;

enum AbilityEnum: string
{
    case STR = 'str';
    case DEX = 'dex';
    case CON = 'con';
    case INT = 'int';
    case WIS = 'wis';
    case CHA = 'cha';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
