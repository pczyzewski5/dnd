<?php

namespace DND\Calculators;

use DND\Domain\Ability\Abilities;

class ArmorClassCalculator
{
    public static function calculate(Abilities $abilities): int
    {
       return $abilities->getDex()->getModifier() + 10;
    }
}