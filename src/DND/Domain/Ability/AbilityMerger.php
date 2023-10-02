<?php

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;
use DND\Race\Race;

class AbilityMerger
{
    public static function merge(
        Abilities $abilities,
        Race $race,
    ): Abilities {
        $abilities = \array_map(static function(Ability $ability) {
            return $ability->getValue();
        }, $abilities->toArray());

        foreach ($race->getASI() as $ability => $value) {
            if (false === AbilityEnum::isValid($ability)) {
                // @todo change me
                throw new \Exception($ability . ' ability does not exists.');
            }

            $abilities[$ability] += $value;
        }

        return AbilitiesFactory::fromArray($abilities);
    }
}
