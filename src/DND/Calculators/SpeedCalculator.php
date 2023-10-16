<?php

namespace DND\Calculators;

use DND\Race\Race;
use DND\Skill\Skills\FastMovement;

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