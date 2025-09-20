<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\AbilityEnum;
use App\Enum\AbilitySkillEnum;

class AbilityService
{
    public function getAbilityForAbilitySkill(AbilitySkillEnum $enum): AbilityEnum
    {
        return match ($enum) {
            AbilitySkillEnum::ACROBATICS => AbilityEnum::DEX,
            AbilitySkillEnum::ATHLETICS => AbilityEnum::STR,
            AbilitySkillEnum::HISTORY => AbilityEnum::INT,
            AbilitySkillEnum::INSIGHT => AbilityEnum::WIS,
            AbilitySkillEnum::MEDICINE => AbilityEnum::WIS,
            AbilitySkillEnum::ANIMAL_HANDLING => AbilityEnum::WIS,
            AbilitySkillEnum::DECEPTION => AbilityEnum::CHA,
            AbilitySkillEnum::PERCEPTION => AbilityEnum::WIS,
            AbilitySkillEnum::PERSUASION => AbilityEnum::CHA,
            AbilitySkillEnum::NATURE => AbilityEnum::INT,
            AbilitySkillEnum::RELIGION => AbilityEnum::INT,
            AbilitySkillEnum::STEALTH => AbilityEnum::DEX,
            AbilitySkillEnum::SURVIVAL => AbilityEnum::WIS,
            AbilitySkillEnum::INVESTIGATION => AbilityEnum::INT,
            AbilitySkillEnum::ARCANA => AbilityEnum::INT,
            AbilitySkillEnum::PERFORMANCE => AbilityEnum::CHA,
            AbilitySkillEnum::INTIMIDATION => AbilityEnum::CHA,
            AbilitySkillEnum::SLEIGHT_OF_HANDS => AbilityEnum::DEX,
        };
    }
}
