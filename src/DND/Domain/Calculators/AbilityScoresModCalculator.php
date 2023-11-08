<?php

namespace DND\Domain\Calculators;

class AbilityScoresModCalculator
{
    public static function calculate(int $abilityScoreValue): int
    {
        if ($abilityScoreValue < 1 || $abilityScoreValue > 30) {
            // @todo change me
            throw new \Exception('invalid ability score');
        }

        $minModValue = -5;

        if (1 === $abilityScoreValue) {
            return $minModValue;
        }

        if (30 === $abilityScoreValue) {
            return 10;
        }

        return (int)\floor($abilityScoreValue / 2) + $minModValue;
    }
}