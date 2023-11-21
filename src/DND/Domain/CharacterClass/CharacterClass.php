<?php

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private array $proficiencies;
    private array $multiclassProficiencies;
    private array $skills;

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
        $this->skills = $this->mergeSkills($skills, $archetypeSkills);
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

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->characterClassEnum->equals($characterClass->getCharacterClassEnum());
    }

    public function getCharacterClassEnum(): CharacterClassEnum
    {
        return $this->characterClassEnum;
    }

    private function mergeSkills(array $skillsA, array $skillsB): array
    {
        $result = [];

        $levels = \range(1, 20);
        foreach ($levels as $level) {
            $skills = \array_merge(
                $skillsA[$level] ?? [],
                $skillsB[$level] ?? []
            );

            if (false === empty($skills)) {
                $result[$level] = $skills;
            }
        }

        return $result;
    }
}