<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;
use DND\Domain\Enum\ProficiencyEnum;

class CharacterClass
{
    private CharacterClassEnum $characterClassEnum;
    private HitDiceEnum $hitDiceEnum;
    /** @var ProficiencyEnum[] $proficiencies */
    private array $proficiencies;
    private ?CharacterClassEnum $mainCharacterClassEnum;

    public function __construct(CharacterClassEnum $characterClassEnum, array $data)
    {
        // @todo create factory for this
        $this->characterClassEnum = $characterClassEnum;

        $this->hitDiceEnum = HitDiceEnum::from($data['hit_dice']);
        foreach ($data['proficiencies'] as $proficiency) {
            $this->proficiencies[] = ProficiencyEnum::from($proficiency);
        }
        $this->mainCharacterClassEnum = \array_key_exists('main_class', $data)
            ? CharacterClassEnum::from($data['main_class'])
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

    public function getProficiencies(): array
    {
        return $this->proficiencies;
    }

    public function getMainCharacterClassEnum(): ?CharacterClassEnum
    {
        return $this->mainCharacterClassEnum;
    }

    public function equals(CharacterClass $characterClass): bool
    {
        return $this->getName() === $characterClass->getName();
    }
}