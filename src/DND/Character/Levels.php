<?php

namespace DND\Character;

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

    public function getFirstLevel(): Level
    {
        $result = null;

        foreach ($this->levels as $level) {
            if (1 === $level->getLevel()) {
                $result = $level;
                break;
            }
        }

        if (null === $result) {
            // @todo changeme
            throw new \Exception('Cannot find first level!');
        }

        return $result;
    }

    /**
     * @return Level[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }
}
