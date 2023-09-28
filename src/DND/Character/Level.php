<?php

namespace DND\Character;

use DND\Domain\Enum\CharacterClassEnum;

class Level
{
    private int $level;
    private CharacterClassEnum $characterClass;

    public function __construct(int $level, CharacterClassEnum $characterClass)
    {
        $this->level = $level;
        $this->characterClass = $characterClass;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getCharacterClass(): CharacterClassEnum
    {
        return $this->characterClass;
    }
}