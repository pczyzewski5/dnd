<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;

class Race
{
    private RaceEnum $enum;
    private float $speed;
    private float $nightvision;
    private array $ASI;

    public function __construct(RaceEnum $raceEnum, array $data)
    {
        $this->enum = $raceEnum;

        $this->speed = $data['speed_in_meters'];
        $this->nightvision = $data['nightvision'];
        $this->ASI = $data['ASI'];
    }

    public function getName(): string
    {
        return $this->enum->getValue();
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }

    public function getNightvision(): int
    {
        return $this->nightvision;
    }

    public function getASI(): array
    {
        return $this->ASI;
    }
}
