<?php

namespace DND\Calculators;

class DistanceCalculator
{
    public static function metersToHex(float $meters): float
    {
        return $meters / 1.5;
    }
}