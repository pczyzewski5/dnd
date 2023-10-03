<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private HitDiceEnum $hitDiceEnum;

    public function __construct(CharacterClassEnum $characterClassEnum, array $data)
    {
        $this->characterClassEnum = $characterClassEnum;

        $this->hitDiceEnum = HitDiceEnum::from($data['hit_dice']);
    }

    public function getName(): string
    {
        return $this->characterClassEnum->getValue();
    }

    public function getHitDiceEnum(): HitDiceEnum
    {
        return $this->hitDiceEnum;
    }

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->getName() === $characterClass->getName();
    }
}