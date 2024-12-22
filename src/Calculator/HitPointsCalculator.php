<?php

namespace App\Calculator;

use App\Ability\Abilities;
use App\Entity\Level;
use App\HitDice\HitDiceMapper;
use App\Level\Levels;

use function array_map;
use function array_sum;

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
        array $levels,
        int $conModifier
    ): int {
        $hitPoints = array_map(
            function (Level $level) use ($conModifier): int {
                $hitDice = $level->getCharacterClass()->getHitDice();

                return $level->getLevel() === 1
                    ? $hitDice + $conModifier
                    : \ceil(($hitDice + 1) / 2) + $conModifier;
            },
            $levels
        );

        return array_sum($hitPoints);
    }
}