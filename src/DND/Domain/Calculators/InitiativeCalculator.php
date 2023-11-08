<?php

namespace DND\Domain\Calculators;

use DND\Domain\Ability\Abilities;

class InitiativeCalculator
{
    public static function calculate(Abilities $abilities, array $skills): int
    {
       $initiative = $abilities->getDex()->getModifier();

       foreach ($skills as $skill) {
           if ($skill instanceof \DND\Domain\Skill\Skills\FeatAlert) {
               $initiative += 5;
               break;
           }
       }

       return $initiative;
    }
}