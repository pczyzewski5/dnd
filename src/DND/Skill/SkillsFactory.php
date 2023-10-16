<?php

namespace DND\Skill;

use DND\CharacterClass\CharacterClass;
use DND\Race\Race;

class SkillsFactory
{
   public static function create(CharacterClass $characterClass, Race $race, array $skills, ?CharacterClass $characterSubclass): Skills
   {
       $result = new Skills();

       foreach ($skills as $skill) {
           $result->addSkill(new Skill($skill));
       }
       foreach ($characterClass->getSkills() as $level => $skills) {
           foreach ($skills as $skill) {
               $result->addSkill(new Skill($skill, $level));
           }
       }
       foreach ($characterClass->getArchetypeSkills() as $level => $skills) {
           foreach ($skills as $skill) {
               $result->addSkill(new Skill($skill, $level));
           }
       }
       foreach ($race->getSkills() as $skill) {
           $result->addSkill(new Skill($skill));
       }
       if (null !== $characterSubclass) {
           foreach ($characterSubclass->getSkills() as $level => $skills) {
               foreach ($skills as $skill) {
                   $result->addSkill(new Skill($skill, $level));
               }
           }
           foreach ($characterSubclass->getArchetypeSkills() as $level => $skills) {
               foreach ($skills as $skill) {
                   $result->addSkill(new Skill($skill, $level));
               }
           }
       }

       return $result;
   }
}
