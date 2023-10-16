<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private array $proficiencies;
    private array $multiclassProficiencies;
    private array $skills;
    private array $archetypeSkills;

    public function __construct(
        CharacterClassEnum $characterClassEnum,
        array $proficiencies,
        array $multiclassProficiencies,
        array $skills,
        array $archetypeSkills
    ) {
        $this->characterClassEnum = $characterClassEnum;
        $this->proficiencies = $proficiencies;
        $this->multiclassProficiencies = $multiclassProficiencies;
        $this->skills = $skills;
        $this->archetypeSkills = $archetypeSkills;
    }

    public function getName(): string
    {
        return $this->characterClassEnum->getValue();
    }

    public function getProficiencies(): array
    {
        return $this->proficiencies;
    }

    public function getMulticlassProficiencies(): array
    {
        return $this->multiclassProficiencies;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function getArchetypeSkills(): array
    {
        return $this->archetypeSkills;
    }

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->characterClassEnum->equals($characterClass->getCharacterClassEnum());
    }

    public function getCharacterClassEnum(): CharacterClassEnum
    {
        return $this->characterClassEnum;
    }

    public function getParentCharacterClassEnum(): ?CharacterClassEnum
    {
        return CharacterClassHelper::isBaseClass($this->characterClassEnum)
            ? null
            : CharacterClassHelper::getBaseClass($this->characterClassEnum);
    }
}
