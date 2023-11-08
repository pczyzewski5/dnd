<?php

namespace DND\Domain\AbilitySkills;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\AbilitySkillEnum;
use DND\Domain\Level\Levels;
use DND\Domain\Proficiency\Proficiencies;

class AbilitySkillsFactory
{
    public static function create(
        Abilities $abilities,
        Proficiencies $proficiencies,
        Levels $levels
    ): AbilitySkills {
        $proficiencyBonus = $levels->getProficiencyBonus();

        return new AbilitySkills(
            new AbilitySkill(AbilitySkillEnum::ACROBATICS(), $proficiencies, $abilities->getDex(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::ATHLETICS(), $proficiencies, $abilities->getStr(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::HISTORY(), $proficiencies, $abilities->getInt(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::INSIGHT(), $proficiencies, $abilities->getWis(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::MEDICINE(), $proficiencies, $abilities->getWis(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::ANIMAL_HANDLING(), $proficiencies, $abilities->getWis(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::DECEPTION(), $proficiencies, $abilities->getCha(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::PERCEPTION(), $proficiencies, $abilities->getWis(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::PERSUASION(), $proficiencies, $abilities->getCha(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::NATURE(), $proficiencies, $abilities->getInt(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::RELIGION(), $proficiencies, $abilities->getInt(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::STEALTH(), $proficiencies, $abilities->getDex(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::SURVIVAL(), $proficiencies, $abilities->getWis(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::INVESTIGATION(), $proficiencies, $abilities->getInt(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::ARCANA(), $proficiencies, $abilities->getInt(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::PERFORMANCE(), $proficiencies, $abilities->getCha(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::INTIMIDATION(), $proficiencies, $abilities->getCha(), $proficiencyBonus),
            new AbilitySkill(AbilitySkillEnum::SLEIGHT_OF_HANDS(), $proficiencies, $abilities->getDex(), $proficiencyBonus),
        );
    }
}