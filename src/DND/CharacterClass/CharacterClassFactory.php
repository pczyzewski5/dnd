<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;

class CharacterClassFactory
{
    public static function create(CharacterClassEnum $characterClassEnum): CharacterClass
    {
        $characterClassData = CharacterClassDataRepository::getCharacterClassData(
            CharacterClassHelper::isBaseClass($characterClassEnum)
                ? $characterClassEnum
                : CharacterClassHelper::getBaseClass($characterClassEnum)
        );

        $characterArchetypeData = CharacterClassHelper::isArchetype($characterClassEnum)
            ? CharacterClassDataRepository::getCharacterArchetypeData($characterClassEnum)
            : [];

        return new CharacterClass(
            $characterClassEnum,
            $characterClassData['proficiencies'],
            $characterClassData['multiclass_proficiencies'],
            $characterClassData['skills'],
            $characterArchetypeData['skills'] ?? []
        );
    }
}
