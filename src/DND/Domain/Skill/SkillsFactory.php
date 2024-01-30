<?php

declare(strict_types=1);

namespace DND\Domain\Skill;

use DND\Domain\Character\Character;

class SkillsFactory
{
    public static function create(Character $character, array $extraSkills): Skills
    {
        $result = new Skills();

        foreach ($character->getCharacterClassCollection()->getCharacterClasses() as $characterClass) {
            foreach ($characterClass->getSkills() as $skillName) {
                $result->addSkill(SkillFactory::create($character, $skillName));
            }
        }

        foreach ($extraSkills as $skillName) {
            $result->addSkill(SkillFactory::create($character, $skillName));
        }

        foreach ($character->getRace()->getSkills() as $skillName) {
            $result->addSkill(SkillFactory::create($character, $skillName));
        }

        return $result;
    }
}
