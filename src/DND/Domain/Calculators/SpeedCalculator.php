<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Race\Race;
use DND\Domain\Skill\Skills;
use DND\Domain\Skill\Skills\FastMovement;

class SpeedCalculator
{
    public static function calculate(Race $race, Skills $skills): int
    {
        $speed = DistanceCalculator::metersToHex($race->getSpeed());

        if ($skills->hasSkill(FastMovement::class)) {
            $speed += 2;
        }

        return \intval($speed);
    }
}