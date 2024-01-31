<?php

declare(strict_types=1);

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Level\Levels;

class CharacterClassCollectionFactory
{
    public static function createFromLevels(Levels $levels): CharacterClassCollection
    {
        $result = new CharacterClassCollection();

        foreach ($levels->getClassToLevel() as $class => $level) {
            $class = CharacterClassEnum::from($class);

            $archetypeData = CharacterClassHelper::isArchetype($class)
                ? CharacterClassDataRepository::getCharacterArchetypeData($class)
                : [];

            $classData = CharacterClassDataRepository::getCharacterClassData(
                CharacterClassHelper::toBaseClass($class)
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

            $result->addCharacterClass(
                new CharacterClass(
                    $class,
                    $level,
                    self::isMainClass($class, $levels),
                    $classData['proficiencies'],
                    $classData['multiclass_proficiencies'],
                    $allSkills
                )
            );
        }

        return $result;
    }

    // refactor me, move to static class? MainClassResolver or smt
    private static function isMainClass(CharacterClassEnum $givenClass, Levels $levels): bool
    {
        $classExceptions = [
            CharacterClassEnum::SORCERER
        ];

        foreach ($levels->getLevels() as $level) {
            $class = CharacterClassHelper::toBaseClass(
                $level->getCharacterClassEnum()
            );

            if ($level->getLevel() === 1 && \in_array($class, $classExceptions)) {
                return true;
            }

            if (isset($previousClass)) {
                if ($previousClass->equals($class) && $level->getLevel() === $levels->getLevel()) {
                    return true;
                }
                if (!$previousClass->equals($class)) {
                    return $previousClass->equals(
                        CharacterClassHelper::toBaseClass($givenClass)
                    );
                }
            }
            $previousClass = $class;
        }

        return false;
    }
}
