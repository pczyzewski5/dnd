<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Domain\Skill\Skills;
use DND\Domain\Skill\Skills\UnarmoredDefense;
use DND\Domain\Skill\Skills\NaturalArmor;
use DND\Domain\Skill\Skills\FightingStyleProtection;

class ArmorClassCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
        $acs = [$abilities->getDex()->getModifier() + 10];

        if ($skills->hasSkill(UnarmoredDefense::class)) {
            $acs[] = $abilities->getCon()->getModifier() + $abilities->getDex()->getModifier() + 10;
        }
        if ($skills->hasSkill(NaturalArmor::class)) {
            $acs[] = $abilities->getDex()->getModifier() + 13;
        }

        $ac = \max($acs);
        if ($skills->hasSkill(FightingStyleProtection::class)) {
            $ac += 1;
        }

        return $ac;
    }
}