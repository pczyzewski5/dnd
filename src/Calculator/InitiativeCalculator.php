<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Character\Abilities;
use App\Character\Skills;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
       $initiative = $abilities->dex->modifier;

       if ($skills->hasSkill('feat alert')) {
           $initiative += 5;
       }

       return $initiative;
    }
}