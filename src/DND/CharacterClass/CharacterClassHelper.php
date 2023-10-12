<?php

namespace DND\CharacterClass;

use DND\Character\Levels;
use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Proficiency\Proficiencies;

class CharacterClassHelper
{
    private const CLASS_TO_ARCHETYPE = [
        CharacterClassEnum::ROUGE => [CharacterClassEnum::ASSASSIN],
        CharacterClassEnum::BARBARIAN => [CharacterClassEnum::BERSERKER],
    ];

    public Levels $levels;
    public CharacterClass $characterClass;
    public ?CharacterClass $characterSubclass;

    public function __construct(Levels $levels)
    {
        $this->levels = $levels;
        $this->characterClass = CharacterClassResolver::getCharacterClass($levels);
        $this->characterSubclass = CharacterClassResolver::getCharacterSubclass($levels);
    }

    public static function isBaseClass(CharacterClassEnum $characterClassEnum): bool
    {
        return \in_array(
            $characterClassEnum->getValue(),
            \array_keys(self::CLASS_TO_ARCHETYPE)
        );
    }

    public static function isArchetype(CharacterClassEnum $characterClassEnum): bool
    {
        return false === self::isBaseClass($characterClassEnum);
    }

    public static function getBaseClass(CharacterClassEnum $characterClassEnum): CharacterClassEnum
    {
        foreach (self::CLASS_TO_ARCHETYPE as $baseClass => $archetypes) {
            if (\in_array($characterClassEnum->getValue(), $archetypes)) {
                return CharacterClassEnum::from($baseClass);
            }
        }
    }

    public function getSkills(): array
    {
        $skills = $this->characterClass->getSkills();

        if (null !== $this->characterSubclass) {
            $skills = \array_merge(
                $this->characterSubclass->getSkills(),
                $skills
            );
        }

        return $skills;
    }
}
