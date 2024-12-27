<?php

declare(strict_types=1);

namespace App\Ability;

use App\Calculator\AbilityModifierCalculator;
use App\Enum\AbilityEnum;

class AbilityFactory
{
    public static function create(AbilityEnum $ability, int $value): Ability
    {
        return new Ability(
            $ability,
            $value,
            AbilityModifierCalculator::calculate($value)
        );
    }
}
