<?php

namespace DND\Calculators;

use DND\Character\Levels;
use DND\Domain\Ability\Abilities;

class HitPointsCalculator
{
    public static function calculate(Abilities $abilities, Levels $levels): int
    {
        $hitPoints = 0;
        $levels = $levels->getLevels();
        $conModifier = $abilities->getCon()->getModifier();

        $hitPoints += \array_shift($levels)
                ->getCharacterClass()
                ->getHitDiceEnum()
                ->getValue();
        $hitPoints += $conModifier;

        foreach ($levels as $level) {
            $hitDice = $level->getCharacterClass()->getHitDiceEnum()->getValue();
            // hit dice average is (side count + 1) / 2
            $hitPoints+= \ceil(($hitDice+1)/2) + $conModifier;
        }

        return $hitPoints;
    }
}