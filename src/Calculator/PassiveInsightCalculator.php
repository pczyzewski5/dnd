<?php

namespace App\Calculator;

use App\Ability\Abilities;
use App\Ability\Abilities;
use App\Enum\ProficiencyEnum;
use App\Proficiency\NewProficiencies;
use App\Proficiency\Proficiencies;

use function in_array;

class PassiveInsightCalculator
{
    public static function calculate(Abilities $abilities, Proficiencies $proficiencies, int $proficiencyBonus): int
    {
        $baseValue = 10;

        if ($proficiencies->hasProficiency(ProficiencyEnum::INSIGHT)) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->getWis()->getModifier();
    }

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