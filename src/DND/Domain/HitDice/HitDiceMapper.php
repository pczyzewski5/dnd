<?php

declare(strict_types=1);

namespace DND\Domain\HitDice;

use DND\Domain\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class HitDiceMapper
{
    private const CLASS_TO_DICE = [
        CharacterClassEnum::SORCERER => HitDiceEnum::D6,
        CharacterClassEnum::ROUGE => HitDiceEnum::D8,
        CharacterClassEnum::DRUID => HitDiceEnum::D8,
        CharacterClassEnum::RANGER => HitDiceEnum::D10,
        CharacterClassEnum::PALADIN => HitDiceEnum::D10,
        CharacterClassEnum::FIGHTER => HitDiceEnum::D10,
        CharacterClassEnum::BARBARIAN => HitDiceEnum::D12,
    ];

    public static function getHitDice(CharacterClassEnum $characterClassEnum): HitDiceEnum
    {
        return HitDiceEnum::from(
            self::CLASS_TO_DICE[CharacterClassHelper::toBaseClass($characterClassEnum)->getValue()]
        );
    }
}
