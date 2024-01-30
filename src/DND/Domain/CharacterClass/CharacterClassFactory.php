<?php

declare(strict_types=1);

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Level\Levels;

class CharacterClassFactory
{
    /**
     * @return CharacterClass[]
     */
    public static function createFromLevels(Levels $levels): array
    {
        $result = [];

        foreach ($levels->getClassToLevel() as $class => $level) {
            $class = CharacterClassEnum::from($class);

            $archetypeData = CharacterClassHelper::isArchetype($class)
                ? CharacterClassDataRepository::getCharacterArchetypeData($class)
                : [];

            $classData = CharacterClassHelper::isBaseClass($class)
                ? CharacterClassDataRepository::getCharacterClassData($class)
                : CharacterClassDataRepository::getCharacterClassData(
                    CharacterClassHelper::getBaseClass($class)
                );

            $allSkills = [];

            foreach ($archetypeData['skills'] ?? [] as $skillsLevel => $skills) {
                if ($skillsLevel <= $level) {
                    foreach ($skills as $skill) {
                        $allSkills[] = $skill;
                    }
                }
            }

            foreach ($classData['skills'] as $skillsLevel => $skills) {
                if ($skillsLevel <= $level) {
                    foreach ($skills as $skill) {
                        $allSkills[] = $skill;
                    }
                }
            }

            $result[] = new CharacterClass(
                $class,
                self::isMainClass($class, $levels),
                $classData['proficiencies'],
                $classData['multiclass_proficiencies'],
                $allSkills
            );
        }

        return $result;
    }

    private static function isMainClass(CharacterClassEnum $givenClass, Levels $levels): bool
    {
        $isMainClass = false;

        foreach ($levels->getLevels() as $level) {
            $class = $level->getCharacterClassEnum();
            if (CharacterClassHelper::isArchetype($class)) {
                $class = CharacterClassHelper::getBaseClass($class);
            }

            if (isset($previousClass)) {
                if (!$previousClass->equals($class)) {
                    if (CharacterClassHelper::isArchetype($givenClass)) {
                        $givenClass = CharacterClassHelper::getBaseClass($givenClass);
                    }

                    $isMainClass = $previousClass->equals($givenClass);
                    break;
                }
            }
            $previousClass = $class;
        }

        return $isMainClass;
    }
}
