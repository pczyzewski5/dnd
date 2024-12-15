<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Ability\Abilities;
use App\Enum\SkillEnum;
use App\Skill\Skills;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
       $initiative = $abilities->getDex()->getModifier();

       if ($skills->hasSkill(SkillEnum::FEAT_ALERT)) {
           $initiative += 5;
       }

       return $initiative;
    }
}