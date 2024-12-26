<?php

declare(strict_types=1);

namespace App\SavingThrows;

use App\Enum\NewAbilityEnum;

class NewSavingThrow
{
    public function __construct(
        public readonly NewAbilityEnum $enum,
        public readonly int $value,
        public readonly bool $hasProficiency
    ) {
    }
}
