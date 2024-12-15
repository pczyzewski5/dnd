<?php

namespace App\Calculator;

use App\Ability\Abilities;
use App\Enum\ProficiencyEnum;
use App\Proficiency\Proficiencies;

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
}