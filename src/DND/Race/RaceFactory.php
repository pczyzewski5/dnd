<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceFactory
{
    public static function create(string $race): Race
    {
        $race = RaceEnum::from($race);
        $data = RaceDataRepository::get($race);

        return new Race(
            $race,
            $data['speed_in_meters'],
            $data['nightvision_in_meters'],
            $data['languages'],
            $data['ASI'],
            $data['skills']
        );
    }
}