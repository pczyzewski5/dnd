<?php

namespace App\Calculator;

class AbilityModifierCalculator
{
    public static function calculate(int $abilityValue): int
    {
        if ($abilityValue < 1 || $abilityValue > 30) {
            throw new \InvalidArgumentException(
                'Ability value must be between 1 and 30.'
            );
        }

        return (int) floor($abilityValue / 2) - 5;
    }
}