<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassHelper
{
    private const CLASS_TO_ARCHETYPE = [
        CharacterClassEnum::RANGER => [],
        CharacterClassEnum::ROUGE => [CharacterClassEnum::ASSASSIN],
        CharacterClassEnum::BARBARIAN => [CharacterClassEnum::BERSERKER],
        CharacterClassEnum::PALADIN => [CharacterClassEnum::OATH_OF_THE_ANCIENTS_PALADIN],
        CharacterClassEnum::SORCERER => [CharacterClassEnum::WILD_MAGIC_SORCERER],
        CharacterClassEnum::DRUID => [CharacterClassEnum::CIRCLE_OF_MOON_DRUID],
    ];

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

        // @todo changeme
        throw new \Exception('Base class not found');
    }
}
