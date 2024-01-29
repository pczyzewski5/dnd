<?php

declare(strict_types=1);

namespace DND\Domain\Race;

use DND\Domain\Enum\RaceEnum;

class RaceHelper
{
    private const RACE_TO_SUBRACE = [
        RaceEnum::HALFLING => [RaceEnum::LIGHTFOOT_HALFLING],
        RaceEnum::HUMAN => [RaceEnum::HUMAN_VARIANT],
        RaceEnum::DRAGONBORN => [RaceEnum::COPPER_DRAGONBORN],
        RaceEnum::TIEFLING => [],
        RaceEnum::LIZARDFOLK => [],
        RaceEnum::ELF => [RaceEnum::HIGH_ELF],
    ];

    public static function isBaseRace(RaceEnum $raceEnum): bool
    {
        return \in_array(
            $raceEnum->getValue(),
            \array_keys(self::RACE_TO_SUBRACE)
        );
    }

    public static function isSubrace(RaceEnum $raceEnum): bool
    {
        return false === self::isBaseRace($raceEnum);
    }

    public static function getBaseRace(RaceEnum $raceEnum): RaceEnum
    {
        foreach (self::RACE_TO_SUBRACE as $baseClass => $archetypes) {
            if (\in_array($raceEnum->getValue(), $archetypes)) {
                return RaceEnum::from($baseClass);
            }
        }

        throw new \Exception('Base race not found.');
    }
}
