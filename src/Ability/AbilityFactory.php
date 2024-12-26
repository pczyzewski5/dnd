<?php

declare(strict_types=1);

namespace App\Ability;

use App\Calculator\AbilityModifierCalculator;
use App\Enum\NewAbilityEnum;

class AbilityFactory
{
    public static function create(NewAbilityEnum $ability, int $value): Ability
    {
        return new Ability(
            $ability,
            $value,
            AbilityModifierCalculator::calculate($value)
        );
    }
}
