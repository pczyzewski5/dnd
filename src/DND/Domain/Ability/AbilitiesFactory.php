<?php

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;

class AbilitiesFactory
{
    public static function create(array $startingAbilities): Abilities
    {
        return new Abilities(
            new Ability($startingAbilities[AbilityEnum::STR]),
            new Ability($startingAbilities[AbilityEnum::DEX]),
            new Ability($startingAbilities[AbilityEnum::CON]),
            new Ability($startingAbilities[AbilityEnum::INT]),
            new Ability($startingAbilities[AbilityEnum::WIS]),
            new Ability($startingAbilities[AbilityEnum::CHA]),
        );
    }
}