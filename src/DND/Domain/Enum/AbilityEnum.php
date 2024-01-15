<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class AbilityEnum extends Enum
{
    const STR = 'str';
    const DEX = 'dex';
    const CON = 'con';
    const INT = 'int';
    const WIS = 'wis';
    const CHA = 'cha';
}