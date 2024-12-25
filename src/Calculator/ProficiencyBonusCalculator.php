<?php

namespace App\Calculator;

use function count;
use function ceil;

class ProficiencyBonusCalculator
{
    public function calculate(array $levels): int
    {
        return (int) ceil(1 + (count($levels) / 4));
    }
}