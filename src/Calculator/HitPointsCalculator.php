<?php

namespace App\Calculator;

class HitPointsCalculator
{
    public function calculate(array $levels, int $conModifier): int
    {
        $hitPoints = 0;

        foreach ($levels as $level) {
            $hitDice = $level->getCharacterClass()->getHitDice();

            $hitPoints += $level->getLevel() === 1
                ? $hitDice + $conModifier
                : \ceil(($hitDice + 1) / 2) + $conModifier;
        }

        return $hitPoints;
    }
}