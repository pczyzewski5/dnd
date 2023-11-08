<?php

namespace DND\Domain\Skill;

use DND\Domain\Character\Character;

class SkillsFactory
{
    public static function create(Character $character, array $extraSkills): Skills
    {
        $result = new Skills();

        self::addSkillsWithGrantLevel(
            $character,
            $result,
            $character->getCharacterClass()->getSkills()
        );
        self::addSkillsWithGrantLevel(
            $character,
            $result,
            $character->getRace()->getSkills()
        );
        self::addSkillWithNoGrantLevel(
            $character,
            $result,
            $extraSkills
        );
        if (null !== $character->getCharacterSubclass()) {
            self::addSkillsWithGrantLevel(
                $character,
                $result,
                $character->getCharacterSubclass()->getSkills()
            );
        }

        return $result;
    }

    private static function addSkillsWithGrantLevel(
        Character $character,
        Skills $result,
        array $skillsWithGrantLevel
    ): Skills {
        foreach ($skillsWithGrantLevel as $grantLevel => $skills) {
            foreach ($skills as $skillName) {
                $result->addSkill(
                    SkillFactory::create($character, $skillName, $grantLevel)
                );
            }
        }

        return $result;
    }

    private static function addSkillWithNoGrantLevel(
        Character $character,
        Skills $result,
        array $skills
    ): Skills {
        foreach ($skills as $skillName) {
            $result->addSkill(
                SkillFactory::create($character, $skillName, 0)
            );
        }

        return $result;
    }
}
