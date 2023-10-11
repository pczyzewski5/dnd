<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassRepository
{
    private const CHARACTER_DATA_FILEPATH = __DIR__ . '/character_class.json';
    private const ARCHETYPE_DATA_FILEPATH = __DIR__ . '/character_archetype.json';

    public static function get(CharacterClassEnum $characterClassEnum): CharacterClass
    {
        $characterData = self::findCharacterClassData($characterClassEnum, self::CHARACTER_DATA_FILEPATH);
        if (null !== $characterData) {
            return new CharacterClass($characterClassEnum, $characterData);
        }

        $archetypeData = self::findCharacterClassData($characterClassEnum, self::ARCHETYPE_DATA_FILEPATH);
        if (null !== $archetypeData) {
            $data = self::mergeCharacterClassData(
                self::findCharacterClassData($archetypeData['parent'], self::CHARACTER_DATA_FILEPATH),
                $archetypeData
            );

            return new CharacterClass($characterClassEnum, $data);
        }

        // @todo changeme
        throw new \Exception('Class: ' . $characterClassEnum->getValue() . ', does not exists.');
    }

    private static function mergeCharacterClassData(array $firstData, array $secondData): array
    {
        $firstDataSkills = $firstData['skills'];
        $secondDataSkills = $secondData['skills'];
        $mergedSkills = [];

        foreach (\array_keys($firstDataSkills + $secondDataSkills) as $level) {
            $mergedSkills[$level] = \array_merge($firstDataSkills[$level] ?? [], $secondDataSkills[$level] ?? []);
        }

        $data = \array_merge_recursive($firstData, $secondData);
        $data['skills'] = $mergedSkills;

        return $data;
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
