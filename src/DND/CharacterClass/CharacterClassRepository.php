<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassRepository
{
    private const CHARACTER_DATA_FILEPATH = __DIR__ . '/character_class.json';
    private const ARCHETYPE_DATA_FILEPATH = __DIR__ . '/character_archetype.json';

    public static function get(CharacterClassEnum $characterClassEnum): CharacterClass
    {
        $archetypeData = self::findCharacterClassData($characterClassEnum, self::ARCHETYPE_DATA_FILEPATH);
        if (null !== $archetypeData) {
            $characterClassEnum = CharacterClassEnum::from($archetypeData['parent']);
        }
        $characterData = self::findCharacterClassData($characterClassEnum, self::CHARACTER_DATA_FILEPATH);

        if (null === $characterData && null === $archetypeData) {
            // @todo changeme
            throw new \Exception('Class: ' . $characterClassEnum->getValue() . ', does not exists.');
        }

        return new CharacterClass($characterClassEnum, $characterData, $archetypeData);
    }

    private static function findCharacterClassData(
        CharacterClassEnum|string $characterClass,
        string $filepath
    ): ?array {
        if ($characterClass instanceof CharacterClassEnum) {
            $characterClass = $characterClass->getValue();
        }

        $data = \file_get_contents($filepath);
        $data = \json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // @todo changeme
            throw new \Exception('Invalid json in: ' . $filepath);
        }

        return \array_key_exists($characterClass, $data)
            ? $data[$characterClass]
            : null;
    }
}
