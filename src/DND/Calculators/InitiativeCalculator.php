<?php

namespace DND\Calculators;

use DND\Domain\Ability\Abilities;
use DND\Skill\Skills;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities, array $skills): int
    {
       $initiative = $abilities->getDex()->getModifier();

       foreach ($skills as $skill) {
           if ($skill instanceof Skills\FeatAlert) {
               $initiative += 5;
               break;
           }
       }

       return $initiative;
    }
}