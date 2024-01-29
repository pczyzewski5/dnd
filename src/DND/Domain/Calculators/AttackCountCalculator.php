<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Skill\Skills;
use DND\Domain\Skill\Skills\BonusAttack;

class AttackCountCalculator
{
    public static function calculate(Skills $skills): int
    {
        $count = 1;

        if ($skills->hasSkill(BonusAttack::class)) {
            $count += 1;
        }

        return $count;
    }
}