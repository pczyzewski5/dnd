<?php

namespace DND\Domain\AbilitySkills;

use DND\Domain\Ability\Abilities;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Domain\Proficiency\Proficiencies;

class AbilitySkillsFactory
{
    public static function create(
        Abilities $abilities,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ): AbilitySkills {
        return new AbilitySkills(
            new AbilitySkill($abilities->getDex(), $proficiencies->hasProficiency(ProficiencyEnum::ACROBATICS()), $proficiencyBonus),
            new AbilitySkill($abilities->getStr(), $proficiencies->hasProficiency(ProficiencyEnum::ATHLETICS()), $proficiencyBonus),
            new AbilitySkill($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::HISTORY()), $proficiencyBonus),
            new AbilitySkill($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::INSIGHT()), $proficiencyBonus),
            new AbilitySkill($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::MEDICINE()), $proficiencyBonus),
            new AbilitySkill($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::ANIMAL_HANDLING()), $proficiencyBonus),
            new AbilitySkill($abilities->getCha(), $proficiencies->hasProficiency(ProficiencyEnum::DECEPTION()), $proficiencyBonus),
            new AbilitySkill($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::PERCEPTION()), $proficiencyBonus),
            new AbilitySkill($abilities->getCha(), $proficiencies->hasProficiency(ProficiencyEnum::PERSUASION()), $proficiencyBonus),
            new AbilitySkill($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::NATURE()), $proficiencyBonus),
            new AbilitySkill($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::RELIGION()), $proficiencyBonus),
            new AbilitySkill($abilities->getDex(), $proficiencies->hasProficiency(ProficiencyEnum::STEALTH()), $proficiencyBonus),
            new AbilitySkill($abilities->getWis(), $proficiencies->hasProficiency(ProficiencyEnum::SURVIVAL()), $proficiencyBonus),
            new AbilitySkill($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::INVESTIGATION()), $proficiencyBonus),
            new AbilitySkill($abilities->getInt(), $proficiencies->hasProficiency(ProficiencyEnum::ARCANA()), $proficiencyBonus),
            new AbilitySkill($abilities->getCha(), $proficiencies->hasProficiency(ProficiencyEnum::PERFORMANCE()), $proficiencyBonus),
            new AbilitySkill($abilities->getCha(), $proficiencies->hasProficiency(ProficiencyEnum::INTIMIDATION()), $proficiencyBonus),
            new AbilitySkill($abilities->getDex(), $proficiencies->hasProficiency(ProficiencyEnum::SLEIGHT_OF_HANDS()), $proficiencyBonus),
        );
    }
}