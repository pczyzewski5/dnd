<?php

declare(strict_types=1);

namespace DND\Domain\Race;

use DND\Domain\Enum\RaceEnum;

class RaceFactory
{
    public static function create(string $race): Race
    {
        $raceEnum = RaceEnum::from($race);

        $subraceData = RaceHelper::isSubrace($raceEnum)
            ? RaceDataRepository::getSubraceData($raceEnum)
            : [];

        $raceData = RaceHelper::isBaseRace($raceEnum)
            ? RaceDataRepository::getRaceData($raceEnum)
            : RaceDataRepository::getRaceData(RaceHelper::getBaseRace($raceEnum));

        return new Race(
            $raceEnum,
            $raceData['speed_in_meters'],
            $raceData['nightvision_in_meters'],
            $raceData['languages'],
            $raceData['ASI'] + ($subraceData['ASI'] ?? []),
            $raceData['skills'] + ($subraceData['skills'] ?? [])
        );
    }
}
