<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Ability\Abilities;

class ArmorClassCalculator
{
    public static function newCalculate(
        Abilities $abilities,
    ): int {
        $baseValue = 10;

        return $baseValue + $abilities->dex->modifier;
    }
}