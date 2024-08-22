<?php

declare(strict_types=1);

namespace App\Calculators;

use App\Enum\SkillEnum;
use App\Race\Race;
use App\Skill\Skills;

class SpeedCalculator
{
    public static function calculate(Race $race, Skills $skills): int
    {
        $speed = DistanceCalculator::metersToHex($race->getSpeed());

        if ($skills->hasSkill(SkillEnum::FAST_MOVEMENT)) {
            $speed += 2;
        }

        return $speed;
    }
}