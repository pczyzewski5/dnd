<?php

namespace DND\Domain\Level;

use DND\Domain\Enum\CharacterClassEnum;

class Level
{
    private CharacterClassEnum $characterClass;
    private int $level;

    public function __construct(CharacterClassEnum $characterClass, int $level)
    {
        $this->characterClass = $characterClass;
        $this->level = $level;
    }

    public function getCharacterClassEnum(): CharacterClassEnum
    {
        return $this->characterClass;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}