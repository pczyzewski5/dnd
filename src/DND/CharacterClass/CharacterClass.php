<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private HitDiceEnum $hitDiceEnum;
    private ?CharacterClassEnum $mainCharacterClassEnum;

    public function __construct(CharacterClassEnum $characterClassEnum, array $data)
    {
        $this->characterClassEnum = $characterClassEnum;

        $this->hitDiceEnum = HitDiceEnum::from($data['hit_dice']);
        $this->mainCharacterClassEnum = \array_key_exists('main_class', $data)
            ? CharacterClassEnum::from($data['main_class'])
            : null;
    }

    public function getName(): string
    {
        return $this->characterClassEnum->getValue();
    }

    public function getHitDiceEnum(): HitDiceEnum
    {
        return $this->hitDiceEnum;
    }

    public function getMainCharacterClassEnum(): ?CharacterClassEnum
    {
        return $this->mainCharacterClassEnum;
    }

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->getName() === $characterClass->getName();
    }
}