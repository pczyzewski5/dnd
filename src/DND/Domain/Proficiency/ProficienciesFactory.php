<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class ProficienciesFactory
{
   public static function fromArray(array $proficiencies): Proficiencies
   {
       $result = new Proficiencies();

       foreach ($proficiencies as $data) {
           foreach ($data as $proficiency) {
               $result->addProficiency(
                   ProficiencyEnum::from($proficiency)
               );
           }
       }

       return $result;
   }
}