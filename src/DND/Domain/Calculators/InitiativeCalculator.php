<?php

declare(strict_types=1);

namespace DND\Domain\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Domain\Skill\Skills;
use DND\Domain\Skill\Skills\FeatAlert;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities, Skills $skills): int
    {
       $initiative = $abilities->getDex()->getModifier();

       if ($skills->hasSkill(FeatAlert::class)) {
           $initiative += 5;
       }

       return $initiative;
    }
}