<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Character\Skills;
use App\Dto\RaceConfigDto;

class SpeedCalculator
{
    public function calculate(
        RaceConfigDto $raceConfig,
        Skills $skills
    ): int {
        $speed = DistanceCalculator::metersToHex($raceConfig->speed);

        if ($skills->hasSkill('fast movement')) {
            $speed += 2;
        }

        return $speed;
    }
}