<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassFactory
{
    public static function createFromString(string $characterClass): CharacterClass
    {
        if (false === CharacterClassEnum::isValid($characterClass)) {
            // @todo change me
            throw new \Exception('Invalid class: ' . $characterClass);
        }

        $characterClassEnum = CharacterClassEnum::from($characterClass);

        return new CharacterClass(
            $characterClassEnum,
            CharacterClassRepository::getByCharacterClass($characterClassEnum)
        );
    }
}