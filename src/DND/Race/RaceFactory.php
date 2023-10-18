<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceFactory
{
    public static function create(string $race): Race
    {
        $raceEnum = RaceEnum::from($race);

        $subraceData = RaceHelper::isSubrace($raceEnum)
            ? RaceDataRepository::getSubraceData($raceEnum)
            : [];

        $raceData = RaceHelper::isSubrace($raceEnum)
            ? RaceDataRepository::getRaceData(RaceHelper::getBaseRace($raceEnum))
            : RaceDataRepository::getRaceData($raceEnum);

        return new Race(
            $raceEnum,
            $raceData['speed_in_meters'],
            $raceData['nightvision_in_meters'],
            $raceData['languages'],
            $raceData['ASI'] + ($subraceData['ASI'] ?? []),
            $raceData['skills'],
            $subraceData['skills'] ?? []
        );
    }
}
