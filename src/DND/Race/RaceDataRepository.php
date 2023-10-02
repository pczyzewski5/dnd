<?php

namespace DND\Race;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\HitDiceEnum;
use DND\Domain\Enum\RaceEnum;

class RaceDataRepository
{
    public static function get(RaceEnum $raceEnum): array
    {
        $race = $raceEnum->getValue();

        $data = \json_decode(
            \file_get_contents(__DIR__ . '/race_data.json'),
            true
        );

        if (false === \array_key_exists($race, $data)) {
            // @todo change me
            throw new \Exception('Character race: ' . $race . ', not found.');
        }

        return $data[$race];
    }
}