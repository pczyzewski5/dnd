<?php

namespace DND\Skill;

use DND\Character\Character;

class SkillsFactory
{
    public static function create(Character $character, array $extraSkills): Skills
    {
        $result = new Skills();

        foreach ($character->getCharacterClass()->getSkills() as $grantLevel => $skills) {
            foreach ($skills as $skillName) {
                $result->addSkill(
                    SkillFactory::create($character, $skillName, $grantLevel)
                );
            }
        }
        if (null !== $character->getCharacterSubclass()) {
            foreach ($character->getCharacterSubclass()->getSkills() as $grantLevel => $skills) {
                foreach ($skills as $skillName) {
                    $result->addSkill(
                        SkillFactory::create($character, $skillName, $grantLevel)
                    );
                }
            }
        }
        foreach ($character->getRace()->getSkills() as $grantLevel => $skills) {
            foreach ($skills as $skillName) {
                $result->addSkill(
                    SkillFactory::create($character, $skillName, $grantLevel)
                );
            }
        }
        foreach ($extraSkills as $skillName) {
            $result->addSkill(
                SkillFactory::create($character, $skillName, 0)
            );
        }

        return $result;
    }
}
