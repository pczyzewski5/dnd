<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClass;

class Level
{
    private int $level;
    private CharacterClass $characterClass;

    public function __construct(int $level, CharacterClass $characterClass)
    {
        $this->level = $level;
        $this->characterClass = $characterClass;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getCharacterClass(): CharacterClass
    {
        return $this->characterClass;
    }
}