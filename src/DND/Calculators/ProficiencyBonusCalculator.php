<?php

namespace DND\Calculators;

class ProficiencyBonusCalculator
{
    public static function calculate(int $characterLevel): int
    {
        if ($characterLevel > 0 && $characterLevel < 5) {
            return 2;
        }
        if ($characterLevel > 4 && $characterLevel < 9) {
            return 3;
        }
        if ($characterLevel > 8 && $characterLevel < 13) {
            return 4;
        }
        if ($characterLevel > 12 && $characterLevel < 17) {
            return 5;
        }

        return 6;
    }
}