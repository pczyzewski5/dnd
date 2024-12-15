<?php

namespace App\Calculator;

class DistanceCalculator
{
    public static function metersToHex(float $meters): int
    {
        return \intval($meters / 1.5);
    }
}