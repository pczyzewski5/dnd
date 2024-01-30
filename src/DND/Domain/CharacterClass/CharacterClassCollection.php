<?php

declare(strict_types=1);

namespace DND\Domain\CharacterClass;

class CharacterClassCollection
{
    /** @var CharacterClass[] */
    private array $characterClasses;

    public function addCharacterClass(CharacterClass $characterClass): void
    {
        $this->characterClasses[] = $characterClass;
    }

    public function getCharacterClasses(): array
    {
        return $this->characterClasses;
    }

    public function getMainClass(): CharacterClass
    {
        foreach ($this->characterClasses as $characterClass) {
            if ($characterClass->isMainClass()) {
                return $characterClass;
            }
        }

        throw new \Exception('Main class not found');
    }

    public function getSubclass(): ?CharacterClass
    {
        foreach ($this->characterClasses as $characterClass) {
            if ($characterClass->isMainClass() === false) {
                return $characterClass;
            }
        }

        return null;
    }

    public function getMainClassName(): string
    {
        return $this->getMainClass()->getCharacterClassEnum()->getValue();
    }

    public function getSubclassName(): ?string
    {
        return null === $this->getSubclass()
            ? null
            : $this->getSubclass()->getCharacterClassEnum()->getValue();
    }
}
