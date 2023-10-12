<?php

namespace DND\Calculators;

use DND\Character\HitDiceMapper;
use DND\Character\Levels;

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
}