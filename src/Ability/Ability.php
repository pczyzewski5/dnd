<?php

declare(strict_types=1);

namespace App\Ability;

use App\Enum\NewAbilityEnum;

class Ability
{
    public function __construct(
        public readonly NewAbilityEnum $abilityEnum,
        public readonly int $value,
        public readonly int $modifier
    ) {
    }
}
