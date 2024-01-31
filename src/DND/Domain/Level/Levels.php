<?php

declare(strict_types=1);

namespace DND\Domain\Level;

use DND\Domain\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\CharacterClassEnum;

class Levels
{
    /** @var Level[] $levels */
    private array $levels = [];

    public function addLevel(Level $level): void
    {
        if (\array_key_exists($level->getLevel(), $this->levels)) {
            throw new \Exception('Level already exists.');
        }

        $this->levels[] = $level;
    }

    public function getLevel(): int
    {
        return \end($this->levels)->getLevel();
    }

    /**
     * @return Level[]
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    public function getClassToLevel(): array
    {
        $result = [];

        foreach ($this->levels as $level) {
            $class = $level->getCharacterClassEnum()->getValue();

            \array_key_exists($class, $result)
                ? $result[$class] += 1
                : $result[$class] = 1;
        }

        // cannibalize base classes
        foreach ($result as $class => $level) {
            $class = CharacterClassEnum::from($class);
            if (CharacterClassHelper::isArchetype($class)) {
                $baseClass = CharacterClassHelper::toBaseClass($class)->getValue();
                if ($baseClass === CharacterClassEnum::SORCERER) {
                    continue;
                }
                $result[$class->getValue()] += $result[$baseClass];
                unset($result[$baseClass]);
            }
        }

        return $result;
    }

    public function getProficiencyBonus(): int
    {
        return (int)\ceil(1 + (count($this->levels) / 4));
    }
}
