<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClass;

class Levels
{
    /** @var Level[] $levels */
    private array $levels = [];

    public function addLevel(Level $level): void
    {
        if (\array_key_exists($level->getLevel(), $this->levels)) {
            // @todo changeme
            throw new \Exception('level already exists');
        }

        $this->levels[] = $level;
    }

    public function getLevel(): int
    {
        return \count($this->levels);
    }

    /**
     * @return Level[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    /**
     * @return CharacterClass[]
     */
    public function getCharacterClasses(): array
    {
        $result = [];

        foreach ($this->levels as $level) {
            $result[] = $level->getCharacterClass();
        }

        return \array_unique($result, SORT_REGULAR);
    }
}