<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassDataRepository
{
    private const CLASS_DATA_FILEPATH = __DIR__ . '/class_data.json';
    private const ARCHETYPE_DATA_FILEPATH = __DIR__ . '/archetype_data.json';

    public static function getCharacterClassData(CharacterClassEnum $characterClassEnum): array
    {
        $data = self::findData($characterClassEnum, self::CLASS_DATA_FILEPATH);

        if (null === $data) {
            // @todo changeme
            throw new \Exception('Data for class: ' . $characterClassEnum->getValue() . ', not found!');
        }

        return $data;
    }

    public static function getCharacterArchetypeData(CharacterClassEnum $characterClassEnum): array
    {
        $data = self::findData($characterClassEnum, self::ARCHETYPE_DATA_FILEPATH);

        if (null === $data) {
            // @todo changeme
            throw new \Exception('Data for archetype: ' . $characterClassEnum->getValue() . ', not found!');
        }

        return $data;
    }

    private static function findData(
        CharacterClassEnum $characterClassEnum,
        string $dataFilepath
    ): ?array {
        $data = \file_get_contents($dataFilepath);
        $data = \json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // @todo changeme
            throw new \Exception('Invalid json in: ' . $dataFilepath);
        }

        return $data[$characterClassEnum->getValue()] ?? null;
    }
}
