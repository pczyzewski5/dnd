<?php

namespace DND\Character;

use DND\Domain\Enum\CharacterClassEnum;

class Levels
{
    private array $levels;

    public function __construct(array $levels)
    {
        $this->levels = $levels;
    }

    public function getLevel(): int
    {
        return \max(\array_keys($this->levels));
    }

    public function getCharacterClass(): CharacterClassEnum
    {
        return CharacterClassEnum::from(
            \end($this->levels)['class']
        );
    }
}