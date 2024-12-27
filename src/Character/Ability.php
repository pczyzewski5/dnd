<?php

declare(strict_types=1);

namespace App\Character;

use App\Enum\AbilityEnum;

class Ability
{
    public function __construct(
        public readonly AbilityEnum $abilityEnum,
        public readonly int $value,
        public readonly int $modifier
    ) {
    }
}
