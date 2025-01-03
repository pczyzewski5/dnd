<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Character\Abilities;
use App\Character\Skills;

class ArmorClassCalculator
{
    public static function calculate(
        Abilities $abilities,
        Skills $skills,
    ): int {
        $baseValue = 10;

        if ($skills->hasSkill('unarmored defense')) {
            $baseValue += $abilities->con->modifier;
        }

        return $baseValue + $abilities->dex->modifier;
    }
}