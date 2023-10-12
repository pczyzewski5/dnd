<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassRepository
{
    private const CHARACTER_DATA_FILEPATH = __DIR__ . '/class_data.json';
    private const ARCHETYPE_DATA_FILEPATH = __DIR__ . '/archetype_data.json';

    public static function get(CharacterClassEnum $characterClassEnum): CharacterClass
    {
        $archetypeData = CharacterClassHelper::isArchetype($characterClassEnum)
            ? self::findCharacterClassData($characterClassEnum)
            : null;

        $characterData = self::findCharacterClassData(
            CharacterClassHelper::isBaseClass($characterClassEnum)
                ? $characterClassEnum
                : CharacterClassHelper::getBaseClass($characterClassEnum)
        );

        if (null === $characterData && null === $archetypeData) {
            throw new \Exception('Data for class: ' . $characterClassEnum->getValue() . ', does not exists.');
        }

        return new CharacterClass(
            $characterClassEnum,
            $characterData['proficiencies'],
            $characterData['skills'],
            $archetypeData['skills'] ?? []
        );
    }

    private static function findCharacterClassData(CharacterClassEnum $characterClassEnum): ?array
    {
        $getDataFromFile = static function (string $filepath): array {
            $data = \file_get_contents($filepath);
            $data = \json_decode($data, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                // @todo changeme
                throw new \Exception('Invalid json in: ' . $filepath);
            }

            return $data;
        };

        $data = \array_merge(
            $getDataFromFile(self::CHARACTER_DATA_FILEPATH),
            $getDataFromFile(self::ARCHETYPE_DATA_FILEPATH)
        );

        return $data[$characterClassEnum->getValue()] ?? null;
    }
}
