<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassRepository
{
    public static function getByCharacterClass(CharacterClassEnum $characterClassEnum): array
    {
        $characterClass = $characterClassEnum->getValue();

        $characterClassData = \json_decode(
            \file_get_contents(__DIR__ . '/character_class.json'),
            true
        );
        $characterArchetypeData = \json_decode(
            \file_get_contents(__DIR__ . '/character_archtype.json'),
            true
        );

        if (\array_key_exists($characterClass, $characterClassData)) {
            return $characterClassData[$characterClass];
        }
        if (\array_key_exists($characterClass, $characterArchetypeData)) {
            $characterArchetypeData = $characterArchetypeData[$characterClass];
            $characterClassData = $characterClassData[$characterArchetypeData['main_class']];

            return \array_merge_recursive($characterClassData, $characterArchetypeData);
        }

        // @todo change me
        throw new \Exception('Class: ' . $characterClass . ', not found.');
    }
}