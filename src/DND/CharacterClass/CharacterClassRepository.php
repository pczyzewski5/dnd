<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassRepository
{
    public static function getByCharacterClass(CharacterClassEnum $characterClassEnum): CharacterClass
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

        $archetypeData = [];
        $classData = [];
        $skills = [];

        if (\array_key_exists($characterClass, $characterArchetypeData)) {
            $archetypeData = $characterArchetypeData[$characterClass];
            $skills = $archetypeData['skills'];
            $characterClass = $archetypeData['parent_class'];
        }

        if (\array_key_exists($characterClass, $characterClassData)) {
            $classData = $characterClassData[$characterClass];
            foreach ($classData['skills'] as $level => $classSkills) {
                $skills[$level] = \array_merge($classSkills, $skills[$level] ?? []);
            }
        }

        if (empty($classData) && empty($archetypeData)) {
            // @todo chageme
            throw new \Exception('Cannot find class data for: ' . $characterClass);
        }

        $data = \array_merge_recursive($archetypeData, $classData);
        $data['skills'] = $skills;

        return new CharacterClass($characterClassEnum, $data);
    }
}