<?php

namespace DND\CharacterClass;

use DND\Character\Levels;

class CharacterClassResolver
{
    public static function getCharacterClass(Levels $levels): CharacterClass
    {
        $result = CharacterClassRepository::getByCharacterClass(
            $levels->getFirstLevel()->getCharacterClassEnum()
        );

        foreach (self::extractCharacterClasses($levels) as $characterClass) {
            if (null !== $characterClass->getParentCharacterClassEnum()) {
                if ($characterClass->getParentCharacterClassEnum()->equals($result->getCharacterClassEnum())) {
                    $result = $characterClass;
                    break;
                }
            }
        }

        return $result;
    }

    public static function getCharacterSubclass(Levels $levels): ?CharacterClass
    {
        $characterClass = null;
        $characterSubclass = null;

        $characterClasses = self::removeCharacterClass(
            self::getCharacterClass($levels),
            self::extractCharacterClasses($levels)
        );

        foreach ($characterClasses as $item) {
            if (null === $item->getParentCharacterClassEnum()) {
                $characterClass = $item;
            }
            if (null !== $item->getParentCharacterClassEnum()) {
                $characterSubclass = $item;
            }
        }

        return $characterSubclass ?? $characterClass;
    }

    /**
     * @return CharacterClass[]
     */
    private static function removeCharacterClass(CharacterClass $characterClassToRemove, array $characterClasses): array
    {
        $characterClasses = \array_filter($characterClasses, static function (CharacterClass $characterClass) use ($characterClassToRemove): bool {
            return false === $characterClass->equals($characterClassToRemove);
        });
        $characterClasses = \array_filter($characterClasses, static function (CharacterClass $characterClass) use ($characterClassToRemove): bool {
            if (null === $characterClassToRemove->getParentCharacterClassEnum()) {
                return true;
            }

            $characterClassToRemove = CharacterClassRepository::getByCharacterClass(
                $characterClassToRemove->getParentCharacterClassEnum()
            );

            return false === $characterClass->equals($characterClassToRemove);
        });

        return $characterClasses;
    }

    /**
     * @return CharacterClass[]
     */
    private static function extractCharacterClasses(Levels $levels): array
    {
        $characterClasses = [];
        $characterArchetypes = [];

        // sort to character classes and archetypes
        foreach ($levels->getLevels() as $level) {
            $characterClass = CharacterClassRepository::getByCharacterClass(
                $level->getCharacterClassEnum()
            );

            if (null !== $characterClass->getParentCharacterClassEnum()) {
                $characterClasses[] = CharacterClassRepository::getByCharacterClass(
                    $characterClass->getParentCharacterClassEnum()
                );
                $characterArchetypes[] = $characterClass;
            } else {
                $characterClasses[] = $characterClass;
            }
        }

        // remove duplicates and validate
        $characterClasses = \array_unique($characterClasses, SORT_REGULAR);
        $characterArchetypes = \array_unique($characterArchetypes, SORT_REGULAR);

        if (\count($characterClasses) > 2 || \count($characterArchetypes) > 2) {
            // @todo changeme
            throw new \Exception('Only one subclass is supported.');
        }

        // remove archetype parent classes
        $characterClasses = \array_filter($characterClasses, static function (CharacterClass $characterClass) use ($characterArchetypes): bool {
            /** @var CharacterClass $characterArchetype */
            foreach ($characterArchetypes as $characterArchetype) {
                return false === $characterArchetype->getParentCharacterClassEnum()->equals(
                    $characterClass->getCharacterClassEnum()
                );
            }

            return true;
        });

        return \array_merge($characterClasses, $characterArchetypes);
    }
}