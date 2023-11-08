<?php

namespace DND\Domain\Calculators;

use DND\Domain\Skill\Skills\BonusAttack;

class AttackCountCalculator
{
    public static function calculate(array $skills): int
    {
        $count = 1;

        foreach ($skills as $skill) {
            if ($skill instanceof BonusAttack) {
                $count += 1;
            }
        }

        return $count;
    }
}