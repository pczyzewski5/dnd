<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class HitDiceMapper
{
    private const CLASS_TO_DICE = [
        CharacterClassEnum::ROUGE => HitDiceEnum::D8,
        CharacterClassEnum::BARBARIAN => HitDiceEnum::D12,
    ];

    public static function getHitDice(CharacterClassEnum $characterClassEnum): HitDiceEnum
    {
        if (false === CharacterClassHelper::isBaseClass($characterClassEnum)) {
            $characterClassEnum = CharacterClassHelper::getBaseClass($characterClassEnum);
        }

        return HitDiceEnum::from(
            self::CLASS_TO_DICE[$characterClassEnum->getValue()]
        );
    }
}