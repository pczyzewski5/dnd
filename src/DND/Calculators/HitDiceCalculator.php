<?php

namespace DND\Calculators;

use DND\Character\HitDices;
use DND\Character\Levels;

class HitDiceCalculator
{
    public static function calculate(Levels $levels): HitDices
    {
        $hitDices = new HitDices();

        $characterClasses = $levels->getCharacterClasses();
        if (\count($characterClasses) > 2) {
            // @todo changeme
            throw new \Exception('Only one subclass is supported right now.');
        }

        foreach ($levels->getLevels() as $level) {
            foreach ($characterClasses as $characterClass) {
                if ($level->getCharacterClass()->equals($characterClass)) {
                    $hitDices->increaseDiceCount(
                        $level->getCharacterClass()->getHitDiceEnum()
                    );
                }
            }
        }

        return $hitDices;
    }
}