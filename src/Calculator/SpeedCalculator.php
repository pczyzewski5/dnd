<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Character\Skills;
use App\Race\RaceConfig;

class SpeedCalculator
{
    public function calculate(
        RaceConfig $race,
        Skills $skills
    ): int {
        $speed = DistanceCalculator::metersToHex($race->speed);

        if ($skills->hasSkill('fast movement')) {
            $speed += 2;
        }

        return $speed;
    }
}