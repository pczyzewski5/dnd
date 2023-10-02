<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceDataRepository
{
    public static function get(RaceEnum $raceEnum): array
    {
        $race = $raceEnum->getValue();

        $raceData = \json_decode(
            \file_get_contents(__DIR__ . '/race_data.json'),
            true
        );
        $subraceData = \json_decode(
            \file_get_contents(__DIR__ . '/subrace_data.json'),
            true
        );

        if (\array_key_exists($race, $raceData)) {
            return $raceData[$race];
        }
        if (\array_key_exists($race, $subraceData)) {
            $subraceData = $subraceData[$race];
            $mainRaceData = $raceData[$subraceData['main_race']];

            return \array_merge_recursive($mainRaceData, $subraceData);
        }

        // @todo change me
        throw new \Exception('Character race: ' . $race . ', not found.');
    }
}