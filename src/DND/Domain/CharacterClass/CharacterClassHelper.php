<?php

declare(strict_types=1);

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassHelper
{
    private const CLASS_TO_ARCHETYPE = [
        CharacterClassEnum::RANGER => [],
        CharacterClassEnum::FIGHTER => [
            CharacterClassEnum::CAVALIER,
            CharacterClassEnum::BATTLE_MASTER
        ],
        CharacterClassEnum::ROUGE => [CharacterClassEnum::ASSASSIN],
        CharacterClassEnum::BARBARIAN => [
            CharacterClassEnum::BERSERKER,
            CharacterClassEnum::PATH_OF_THE_TOTEM_WARRIOR,
            CharacterClassEnum::PATH_OF_THE_ANCESTRAL_GUARDIAN
        ],
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

    public static function toBaseClass(CharacterClassEnum $characterClassEnum): CharacterClassEnum
    {
        if (self::isBaseClass($characterClassEnum)) {
            return $characterClassEnum;
        }

        foreach (self::CLASS_TO_ARCHETYPE as $baseClass => $archetypes) {
            if (\in_array($characterClassEnum->getValue(), $archetypes)) {
                return CharacterClassEnum::from($baseClass);
            }
        }

        throw new \Exception('Base class not found.');
    }
}
