<?php

declare(strict_types=1);

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\ProficiencyEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private int $isMainClass;
    private array $proficiencies;
    private array $multiclassProficiencies;
    private array $skills;

    public function __construct(
        CharacterClassEnum $characterClassEnum,
        bool $isMainClass,
        array $proficiencies,
        array $multiclassProficiencies,
        array $skills
    ) {
        $this->characterClassEnum = $characterClassEnum;
        $this->isMainClass = $isMainClass;
        $this->proficiencies = $proficiencies;
        $this->multiclassProficiencies = $multiclassProficiencies;
        $this->skills = $skills;
    }

    public function getCharacterClassEnum(): CharacterClassEnum
    {
        return $this->characterClassEnum;
    }

    /**
     * @return ProficiencyEnum[]
     */
    public function getProficiencies(): array
    {
        $result = [];

        $proficiencies = $this->isMainClass
            ? $this->proficiencies
            : $this->multiclassProficiencies;

        foreach ($proficiencies as $proficiency) {
            $result[] = ProficiencyEnum::from($proficiency);
        }

        return $result;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->characterClassEnum->equals($characterClass->getCharacterClassEnum());
    }
}
