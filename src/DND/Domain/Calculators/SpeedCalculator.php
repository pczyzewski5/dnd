<?php

namespace DND\Domain\Calculators;

use DND\Domain\Race\Race;
use DND\Domain\Skill\Skills\FastMovement;

class SpeedCalculator
{
    public static function calculate(Race $race, array $skills): int
    {
        $speed = DistanceCalculator::metersToHex($race->getSpeed());

        foreach ($skills as $skill) {
            if ($skill instanceof FastMovement) {
                $speed += 2;
                break;
            }
        }

        return $speed;
    }
}