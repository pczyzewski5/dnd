<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
   public static function create(array $proficiencies): Proficiencies
   {
       $result = new Proficiencies();

       foreach ($proficiencies['saving_throws'] as $proficiency) {
           $result->addSavingThrowProficiency(
               ProficiencyEnum::from($proficiency)
           );
       }

       return $result;
   }
}