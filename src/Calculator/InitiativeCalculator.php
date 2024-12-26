<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Ability\Abilities;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities): int
    {
       $initiative = $abilities->dex->modifier;

//       if ($skills->hasSkill(SkillEnum::FEAT_ALERT)) {
//           $initiative += 5;
//       }

       return $initiative;
    }
}