<?php

namespace DND\Calculators;

use DND\Character\HitDices;
use DND\Character\Levels;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class HitDiceCalculator
{
    private const HIT_DICE_MAPPING = [
        CharacterClassEnum::ROUGE => HitDiceEnum::D8,
        CharacterClassEnum::ASSASSIN => HitDiceEnum::D8
    ];

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
                    $hitDice = self::HIT_DICE_MAPPING[$characterClass->getValue()];
                    $hitDices->increaseDiceCount(
                        HitDiceEnum::from($hitDice)
                    );
                }
            }
        }

        return $hitDices;
    }
}