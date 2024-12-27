<?php

namespace App\Calculator;

use App\Character\Abilities;
use App\Character\Proficiencies;

use function in_array;

class PassivePerceptionCalculator
{
    public static function newCalculate(
        Abilities $abilities,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ): int {
        $baseValue = 10;

        if (in_array('perception', $proficiencies->getAbilitySkillProficiencies())) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->wis->modifier;
    }
}