<?php

namespace DND\Domain\Calculators;

class DistanceCalculator
{
    public static function metersToHex(float $meters): float
    {
        return $meters / 1.5;
    }
}