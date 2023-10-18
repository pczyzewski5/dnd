<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceDataRepository
{
    private const RACE_DATA_FILEPATH = __DIR__ . '/race_data.json';
    private const SUBRACE_DATA_FILEPATH = __DIR__ . '/subrace_data.json';

    public static function getRaceData(RaceEnum $raceEnum): array
    {
        $data = self::findData($raceEnum, self::RACE_DATA_FILEPATH);

        if (null === $data) {
            // @todo changeme
            throw new \Exception('Data for race: ' . $raceEnum->getValue() . ', not found!');
        }

        return $data;
    }

    public static function getSubraceData(RaceEnum $raceEnum): array
    {
        $data = self::findData($raceEnum, self::SUBRACE_DATA_FILEPATH);

        if (null === $data) {
            // @todo changeme
            throw new \Exception('Data for subrace: ' . $raceEnum->getValue() . ', not found!');
        }

        return $data;
    }

    private static function findData(RaceEnum $characterClassEnum, string $dataFilepath): ?array
    {
        $data = \file_get_contents($dataFilepath);
        $data = \json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            // @todo changeme
            throw new \Exception('Invalid json in: ' . $dataFilepath);
        }

        return $data[$characterClassEnum->getValue()] ?? null;
    }
}
