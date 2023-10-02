<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceFactory
{
    public static function create(string $race): Race
    {
        $race = RaceEnum::from($race);

        return new Race(
            $race,
            RaceDataRepository::get($race)
        );
    }
}