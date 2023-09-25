<?php

namespace DND\Calculators;

use DND\Domain\Ability\Abilities;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities): int
    {
       return $abilities->getDex()->getModifier();
    }
}