<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\SkillEnum;
use DND\Domain\Skill\Skills;

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