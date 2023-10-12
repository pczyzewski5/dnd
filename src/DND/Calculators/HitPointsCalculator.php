<?php

namespace DND\Calculators;

use DND\Character\HitDiceMapper;
use DND\Character\Levels;
use DND\Domain\Ability\Abilities;

class HitPointsCalculator
{
    public static function calculate(Abilities $abilities, Levels $levels): int
    {
        $hitPoints = 0;
        $levels = $levels->getLevels();
        $firstLevel = \array_shift($levels);
        $conModifier = $abilities->getCon()->getModifier();

        $hitPoints += HitDiceMapper::getHitDice($firstLevel->getCharacterClassEnum())->getValue();
        $hitPoints += $conModifier;

        foreach ($levels as $level) {
            $hitDice = HitDiceMapper::getHitDice($level->getCharacterClassEnum())->getValue();
            // hit dice average is (side count + 1) / 2
            $hitPoints+= \ceil(($hitDice+1)/2) + $conModifier;
        }

        return $hitPoints;
    }
}