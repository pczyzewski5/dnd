<?php

namespace DND\Domain;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Domain\Proficiency\Proficiencies;

class PassivePerceptionCalculator
{
    public static function calculate(Abilities $abilities, Proficiencies $proficiencies, int $proficiencyBonus): int
    {
        $baseValue = 10;

        if ($proficiencies->hasProficiency(ProficiencyEnum::PERCEPTION())) {
            $baseValue += $proficiencyBonus;
        }

        return $baseValue + $abilities->getWis()->getModifier();
    }
}