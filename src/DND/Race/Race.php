<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class Race
{
    public function getName(): string
    {
        return RaceEnum::ORC;
    }

    public function getSpeed(): int
    {
        return 30;
    }

    public function getNightvision(): int
    {
        return 33;
    }
}