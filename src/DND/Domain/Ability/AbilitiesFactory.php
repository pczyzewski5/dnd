<?php

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;

class AbilitiesFactory
{
    public static function fromArray(array $startingAbilities): Abilities
    {
        return new Abilities(
            new Ability(AbilityEnum::STR(), $startingAbilities[AbilityEnum::STR]),
            new Ability(AbilityEnum::DEX(), $startingAbilities[AbilityEnum::DEX]),
            new Ability(AbilityEnum::CON(), $startingAbilities[AbilityEnum::CON]),
            new Ability(AbilityEnum::INT(), $startingAbilities[AbilityEnum::INT]),
            new Ability(AbilityEnum::WIS(), $startingAbilities[AbilityEnum::WIS]),
            new Ability(AbilityEnum::CHA(), $startingAbilities[AbilityEnum::CHA]),
        );
    }
}