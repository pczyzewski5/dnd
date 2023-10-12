<?php

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;
use DND\Race\Race;

class AbilitiesFactory
{
    public static function create(Race $race, array $startingAbilities): Abilities
    {
        $abilities = [];
        $raceAsi = $race->getASI();

        foreach ($startingAbilities as $ability => $value) {
            $abilities[$ability] = $value + ($raceAsi[$ability] ?? 0);
        }

        return new Abilities(
            new Ability(AbilityEnum::STR(), $abilities[AbilityEnum::STR]),
            new Ability(AbilityEnum::DEX(), $abilities[AbilityEnum::DEX]),
            new Ability(AbilityEnum::CON(), $abilities[AbilityEnum::CON]),
            new Ability(AbilityEnum::INT(), $abilities[AbilityEnum::INT]),
            new Ability(AbilityEnum::WIS(), $abilities[AbilityEnum::WIS]),
            new Ability(AbilityEnum::CHA(), $abilities[AbilityEnum::CHA]),
        );
    }
}
