<?php

declare(strict_types=1);

namespace App\Calculators;

use App\Ability\Abilities;
use App\Enum\SkillEnum;
use App\Skill\Skills;

class ArmorClassCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
        $acs = [$abilities->getDex()->getModifier() + 10];

        if ($skills->hasSkill(SkillEnum::UNARMORED_DEFENSE)) {
            $acs[] = $abilities->getCon()->getModifier() + $abilities->getDex()->getModifier() + 10;
        }
        if ($skills->hasSkill(SkillEnum::NATURAL_ARMOR)) {
            $acs[] = $abilities->getDex()->getModifier() + 13;
        }

        $ac = \max($acs);
        if ($skills->hasSkill(SkillEnum::FIGHTING_STYLE_PROTECTION)) {
            $ac += 1;
        }

        return $ac;
    }
}