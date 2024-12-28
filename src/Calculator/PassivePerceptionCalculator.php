<?php

namespace App\Calculator;

use App\Character\Abilities;
use App\Character\Proficiencies;

use App\Enum\AbilitySkillEnum;

use function in_array;
use function var_dump;

class PassivePerceptionCalculator
{
    public static function newCalculate(
        Abilities $abilities,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ): int {
        $baseValue = 10;

        if (in_array(AbilitySkillEnum::PERCEPTION->value, $proficiencies->getAbilitySkillProficiencies())) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->wis->modifier;
    }
}