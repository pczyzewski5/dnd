<?php

namespace App\Calculators;

use App\Ability\Abilities;
use App\Enum\ProficiencyEnum;
use App\Proficiency\Proficiencies;

class PassivePerceptionCalculator
{
    public static function calculate(Abilities $abilities, Proficiencies $proficiencies, int $proficiencyBonus): int
    {
        $baseValue = 10;

        if ($proficiencies->hasProficiency(ProficiencyEnum::PERCEPTION)) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->getWis()->getModifier();
    }
}