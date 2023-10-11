<?php

namespace DND\Calculators;

use DND\Character\HitDices;
use DND\CharacterClass\CharacterClass;
use DND\Domain\Ability\Abilities;

class HitPointsCalculator
{
    public static function calculate(
        CharacterClass $characterClass,
        HitDices $hitDices,
        Abilities $abilities
    ): int {
        $conModifier = $abilities->getCon()->getModifier();
        $characterHitDice = $characterClass->getHitDiceEnum();

        // hit point for 1st level
        $hitPoints = $characterClass->getHitDiceEnum()->getValue() + $conModifier;

        foreach ($hitDices->toArray() as $data) {
            $count = $data['count'];
            $hitDice = $data['type'];
            // hit dice average is (side count + 1) / 2
            $hitDiceAverage = ($hitDice->getValue() + 1) / 2;

            // coz one dice was used for 1st level hp
            if ($hitDice->equals($characterHitDice)) {
                $count--;
            }

            $hitPoints+= $count * \ceil($hitDiceAverage + $conModifier);
        }

        return $hitPoints;
    }
}