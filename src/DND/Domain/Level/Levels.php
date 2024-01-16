<?php

declare(strict_types=1);

namespace DND\Domain\Level;

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
        foreach ($this->levels as $level) {
           if (1 === $level->getLevel()) {
               return $level;
           }
        }
    }

    /**
     * @return Level[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    public function getProficiencyBonus(): int
    {
       return (int)\ceil(1 + (count($this->levels) / 4));
    }
}
