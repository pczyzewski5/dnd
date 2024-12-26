<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Race\RaceConfig;

class SpeedCalculator
{
    public function calculate(
        RaceConfig $race
    ): int {
        $speed = DistanceCalculator::metersToHex($race->speed);

//        if ($skills->hasSkill(SkillEnum::FAST_MOVEMENT)) {
//            $speed += 2;
//        }

        return $speed;
    }
}