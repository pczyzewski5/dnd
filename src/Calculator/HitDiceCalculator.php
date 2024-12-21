<?php

namespace App\Calculator;

use App\Collection\Levels;
use App\Entity\Level;
use App\HitDice\HitDiceMapper;

class HitDiceCalculator
{
    public static function calculate(Levels $levels): array
    {
        $result = [];

        foreach ($levels->getLevels() as $level) {
            $hitDice = HitDiceMapper::getHitDice($level->getCharacterClassEnum());
            \array_key_exists($hitDice->getKey(), $result)
                ?  $result[$hitDice->getKey()] += 1
                :  $result[$hitDice->getKey()] = 1;
        }

        return $result;
    }

    public function newCalculate(Levels $levels): array
    {
        $result = [];

        /** @var Level $level */
        foreach ($levels as $level) {
            $hitDice = $level->getCharacterClass()->getHitDice();

            \array_key_exists($hitDice, $result)
                ?  $result[$hitDice] += 1
                :  $result[$hitDice] = 1;
        }

        return $result;
    }
}