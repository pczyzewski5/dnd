<?php

declare(strict_types=1);

namespace App\Character;

use App\Enum\AbilityEnum;

class SavingThrow
{
    public function __construct(
        public readonly AbilityEnum $enum,
        public readonly int $value,
        public readonly bool $hasProficiency
    ) {
    }
}
