<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class RaceFactory
{
    public static function create(RaceEnum $enum): Race
    {
        return new Race();
    }
}