<?php

namespace App\Calculator;

use App\Character\Levels;
use App\Entity\Level;

class HitDiceCalculator
{
    public function calculate(array $levels): array
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