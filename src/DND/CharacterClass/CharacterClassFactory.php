<?php

namespace DND\CharacterClass;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;

class CharacterClassFactory
{
    public static function create(CharacterClassEnum $classEnum): CharacterClass
    {
        return new CharacterClass();
    }
}