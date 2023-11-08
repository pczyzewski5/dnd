<?php

namespace DND\Domain\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Level\Levels;

class CharacterClassResolver
{
    public static function getCharacterClass(Levels $levels): CharacterClassEnum
    {
        $result = $levels->getFirstLevel()->getCharacterClassEnum();

        foreach (self::extractCharacterClasses($levels) as $characterClassEnum) {
            if (CharacterClassHelper::isArchetype($characterClassEnum)) {
                if (CharacterClassHelper::getBaseClass($characterClassEnum)->equals($result)) {
                    $result = $characterClassEnum;
                    break;
                }
            }
        }

        return $result;
    }

    public static function getCharacterSubclass(Levels $levels): ?CharacterClassEnum
    {
        $characterClass = null;
        $characterSubclass = null;

        $characterClasses = self::removeCharacterClass(
            self::getCharacterClass($levels),
            self::extractCharacterClasses($levels)
        );

        foreach ($characterClasses as $item) {
            if (CharacterClassHelper::isBaseClass($item)) {
                $characterClass = $item;
            }
            if (CharacterClassHelper::isArchetype($item)) {
                $characterSubclass = $item;
            }
        }

        return $characterSubclass ?? $characterClass;
    }

    /**
     * @return CharacterClassEnum[]
     */
    private static function removeCharacterClass(CharacterClassEnum $characterClassEnumToRemove, array $characterClasses): array
    {
        $characterClasses = \array_filter($characterClasses, static function (CharacterClassEnum $characterClassEnum) use ($characterClassEnumToRemove): bool {
            return false === $characterClassEnum->equals($characterClassEnumToRemove);
        });
        $characterClasses = \array_filter($characterClasses, static function (CharacterClassEnum $characterClassEnum) use ($characterClassEnumToRemove): bool {
            if (CharacterClassHelper::isBaseClass($characterClassEnumToRemove)) {
                return true;
            }

            return false === $characterClassEnum->equals(CharacterClassHelper::getBaseClass($characterClassEnumToRemove));
        });

        return $characterClasses;
    }

    /**
     * @return CharacterClassEnum[]
     */
    private static function extractCharacterClasses(Levels $levels): array
    {
        $characterClasses = [];
        $characterArchetypes = [];

        // sort to character classes and archetypes
        foreach ($levels->getLevels() as $level) {
            $characterClassEnum = $level->getCharacterClassEnum();

            if (CharacterClassHelper::isArchetype($characterClassEnum)) {
                $characterClasses[] = CharacterClassHelper::getBaseClass($characterClassEnum);
                $characterArchetypes[] = $characterClassEnum;
            } else {
                $characterClasses[] = $characterClassEnum;
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
        $characterClasses = \array_filter($characterClasses, static function (CharacterClassEnum $characterClassEnum) use ($characterArchetypes): bool {
            /** @var CharacterClassEnum $characterArchetype */
            foreach ($characterArchetypes as $characterArchetype) {
                return false === CharacterClassHelper::getBaseClass($characterArchetype)->equals($characterClassEnum);
            }

            return true;
        });

        return \array_merge($characterClasses, $characterArchetypes);
    }
}