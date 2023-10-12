<?php

namespace DND\Race;

use DND\Domain\Enum\RaceEnum;
use DND\Skill\SkillFactory;

class Race
{
    private RaceEnum $enum;
    private float $speed;
    private float $nightvision;
    private array $languages;
    private array $ASI;
    private array $skills;

    public function __construct(RaceEnum $raceEnum, array $data)
    {
        $this->enum = $raceEnum;
        $this->speed = $data['speed_in_meters'];
        $this->nightvision = $data['nightvision_in_meters'];
        $this->languages = $data['languages'];
        $this->ASI = $data['ASI'];
        $this->skills = SkillFactory::createManyOnlyNames($data['skills']);
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

    public function getLanguages(): array
    {
        return $this->languages;
    }

    public function getASI(): array
    {
        return $this->ASI;
    }

    public function getSkills(): array
    {
        return $this->skills;
    }
}
