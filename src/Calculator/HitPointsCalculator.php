<?php

namespace App\Calculator;

use App\Character\Levels;
use App\Entity\Level;

use function array_map;
use function array_sum;

class HitPointsCalculator
{
    public function calculate(
        Levels $levels,
        int $conModifier
    ): int {
        $hitPoints = array_map(
            function (Level $level) use ($conModifier): int {
                $hitDice = $level->getCharacterClass()->getHitDice();

                return $level->getLevel() === 1
                    ? $hitDice + $conModifier
                    : \ceil(($hitDice + 1) / 2) + $conModifier;
            },
            $levels->levels
        );

        return array_sum($hitPoints);
    }
}