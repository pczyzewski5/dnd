<?php

declare(strict_types=1);

namespace DND\Domain\Race;

use DND\Domain\Enum\RaceEnum;

class Race
{
    private RaceEnum $enum;
    private float $speed;
    private float $nightvision;
    private array $languages;
    private array $ASI;
    private array $skills;

    public function __construct(
        RaceEnum $raceEnum,
        float $speed,
        float $nightvision,
        array $languages,
        array $ASI,
        array $raceSkills,
        array $subraceSkills,
    ) {
        $this->enum = $raceEnum;
        $this->speed = $speed;
        $this->nightvision = $nightvision;
        $this->languages = $languages;
        $this->ASI = $ASI;
        $this->skills = $this->mergeSkills($raceSkills, $subraceSkills);
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

    private function mergeSkills(array $skillsA, array $skillsB): array
    {
        $result = [];

        $levels = \range(0, 20);
        foreach ($levels as $level) {
            $skills = \array_merge(
                $skillsA[$level] ?? [],
                $skillsB[$level] ?? []
            );

            if (false === empty($skills)) {
                $result[$level] = $skills;
            }
        }

        return $result;
    }
}
