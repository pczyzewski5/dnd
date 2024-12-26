<?php

namespace App\Calculator;

use App\Ability\Abilities;
use App\Proficiency\NewProficiencies;

use function in_array;

class PassiveInsightCalculator
{
    public static function newCalculate(
        Abilities $abilities,
        NewProficiencies $proficiencies,
        int $proficiencyBonus
    ): int {
        $baseValue = 10;

        if (in_array('insight', $proficiencies->getAbilitySkillProficiencies())) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->wis->modifier;
    }
}