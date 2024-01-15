<?php

declare(strict_types=1);

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;
use DND\Domain\Race\Race;

class AbilitiesFactory
{
    public static function create(
        Race $race,
        array $startingAbilities,
        array $asi
    ): Abilities {
        $abilities = [];

        $raceAsi = $race->getASI();
        foreach ($startingAbilities as $ability => $value) {
            $value += $raceAsi[$ability] ?? 0;
            $value += $asi[$ability] ?? 0;

            $abilities[$ability] = $value;
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
