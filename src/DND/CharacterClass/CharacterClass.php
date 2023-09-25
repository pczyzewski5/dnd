<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class CharacterClass
{
    public function getName(): string
    {
        return CharacterClassEnum::BARBARIAN;
    }

    public function getHitDice(): int
    {
        return HitDiceEnum::D8;
    }
}