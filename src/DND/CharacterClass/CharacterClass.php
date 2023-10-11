<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;
use DND\Domain\Proficiency\Proficiencies;
use DND\Domain\Proficiency\ProficienciesFactory;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private HitDiceEnum $hitDiceEnum;
    private Proficiencies $proficiencies;
    private array $skills;

    private ?CharacterClassEnum $parentCharacterClassEnum;

    public function __construct(CharacterClassEnum $characterClassEnum, array $data)
    {
        // @todo create factory for this
        $this->characterClassEnum = $characterClassEnum;
        $this->hitDiceEnum = HitDiceEnum::from($data['hit_dice']);
        $this->proficiencies = ProficienciesFactory::fromArray($data['proficiencies']);
        $this->skills = $data['skills'];

        $this->parentCharacterClassEnum = \array_key_exists('parent', $data)
            ? CharacterClassEnum::from($data['parent'])
            : null;
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

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->characterClassEnum->equals($characterClass->getCharacterClassEnum());
    }

    public function getSkills(): array
    {
        return $this->skills;
    }

    public function getCharacterClassEnum(): CharacterClassEnum
    {
        return $this->characterClassEnum;
    }

    public function getParentCharacterClassEnum(): ?CharacterClassEnum
    {
        return $this->parentCharacterClassEnum;
    }
}