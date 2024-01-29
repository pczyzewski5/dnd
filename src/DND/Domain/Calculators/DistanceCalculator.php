<?php

namespace DND\Domain\Calculators;

class DistanceCalculator
{
    public static function metersToHex(float $meters): int
    {
        return \intval($meters / 1.5);
    }
}