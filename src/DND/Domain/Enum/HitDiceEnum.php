<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class HitDiceEnum extends Enum
{
    const D6 = 6;
    const D8 = 8;
    const D10 = 10;
    const D12 = 12;
}