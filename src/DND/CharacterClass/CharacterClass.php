<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\Proficiency\ProficienciesFactory;
use DND\Skill\SkillFactory;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private HitDiceEnum $hitDiceEnum;
    private Proficiencies $proficiencies;
    private array $skills;

    public function __construct(
        CharacterClassEnum $characterClassEnum,
        array $classData,
        ?array $archetypeData
    ) {
        // @todo create factory for this
        $this->characterClassEnum = $characterClassEnum;
        $this->hitDiceEnum = HitDiceEnum::from($classData['hit_dice']);
        $this->proficiencies = ProficienciesFactory::fromArray($classData['proficiencies']);
        $this->skills = SkillFactory::createManyWithLevels(
            \array_merge($classData['skills'], $archetypeData['skills'] ?? [])
        );
    }

    public function getName(): string
    {
        return $this->characterClassEnum->getValue();
    }

    public function getHitDiceEnum(): HitDiceEnum
    {
        return $this->hitDiceEnum;
    }

    public function getProficiencies(): Proficiencies
    {
        return $this->proficiencies;
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

    public function getParentCharacterClassEnum(): ?CharacterClassEnum
    {
        return CharacterClassHelper::isBaseClass($this->characterClassEnum)
            ? null
            : CharacterClassHelper::getBaseClass($this->characterClassEnum);
    }
}