<?php

namespace App\Calculator;

use App\Ability\Abilities;
use App\Ability\NewAbility;
use App\Entity\Level;
use App\HitDice\HitDiceMapper;
use App\Collection\Levels;

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

    public function newCalculate(
        Levels $levels,
        NewAbility $condition
    ): int {
        $hitPoints = 0;

        foreach ($levels as $level) {
            $hitPoints += $level->getLevel() === 1
                ? $level->getCharacterClass()->getHitDice() + $condition->modifier
                : \ceil(($level->getCharacterClass()->getHitDice() + 1) / 2) + $condition->modifier;
        }

        return $hitPoints;
    }
}