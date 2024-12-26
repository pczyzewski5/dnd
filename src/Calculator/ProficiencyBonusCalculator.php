<?php

namespace App\Calculator;

use function count;
use function ceil;

class ProficiencyBonusCalculator
{
    public function calculate(int $level): int
    {
        return (int) ceil(1 + ($level / 4));
    }
}