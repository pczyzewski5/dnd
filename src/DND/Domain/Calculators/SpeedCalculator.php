<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Enum\SkillEnum;
use DND\Domain\Race\Race;
use DND\Domain\Skill\Skills;

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