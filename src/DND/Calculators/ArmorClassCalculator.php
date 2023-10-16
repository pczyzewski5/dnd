<?php

namespace DND\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Skill\Skills\UnarmoredDefense;

class ArmorClassCalculator
{
    public static function calculate(Abilities $abilities, array $skills): int
    {
        $ac = $abilities->getDex()->getModifier() + 10;

        foreach ($skills as $skill) {
            if ($skill instanceof UnarmoredDefense) {
                $ac += $abilities->getCon()->getModifier();
                break;
            }
        }

        return $ac;
    }
}