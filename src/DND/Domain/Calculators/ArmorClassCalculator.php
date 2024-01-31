<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\SkillEnum;
use DND\Domain\Skill\Skills;

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