<?php

declare(strict_types=1);

namespace App\Ability;

use App\Calculator\AbilityModifierCalculator;
use App\Enum\NewAbilityEnum;

class NewAbilityFactory
{
    public static function create(NewAbilityEnum $ability, int $value): NewAbility
    {
        return new NewAbility(
            $ability,
            $value,
            AbilityModifierCalculator::calculate($value)
        );
    }
}
