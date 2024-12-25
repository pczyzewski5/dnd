<?php

declare(strict_types=1);

namespace App\Enum;

enum NewAbilitySkillEnum: string
{
    case ACROBATICS = 'acrobatics';
    case ATHLETICS = 'athletics';
    case HISTORY = 'history';
    case INSIGHT = 'insight';
    case MEDICINE = 'medicine';
    case ANIMAL_HANDLING = 'animal handling';
    case DECEPTION = 'deception';
    case PERCEPTION = 'perception';
    case PERSUASION = 'persuasion';
    case NATURE = 'nature';
    case RELIGION = 'religion';
    case STEALTH = 'stealth';
    case SURVIVAL = 'survival';
    case INVESTIGATION = 'investigation';
    case ARCANA = 'arcana';
    case PERFORMANCE = 'performance';
    case INTIMIDATION = 'intimidation';
    case SLEIGHT_OF_HANDS = 'sleight of hands';

    public function getAbilityEnum(): NewAbilityEnum
    {
        return match ($this) {
            self::ACROBATICS => NewAbilityEnum::DEX,
            self::ATHLETICS => NewAbilityEnum::STR,
            self::HISTORY => NewAbilityEnum::INT,
            self::INSIGHT => NewAbilityEnum::WIS,
            self::MEDICINE => NewAbilityEnum::WIS,
            self::ANIMAL_HANDLING => NewAbilityEnum::WIS,
            self::DECEPTION => NewAbilityEnum::CHA,
            self::PERCEPTION => NewAbilityEnum::WIS,
            self::PERSUASION => NewAbilityEnum::CHA,
            self::NATURE => NewAbilityEnum::INT,
            self::RELIGION => NewAbilityEnum::INT,
            self::STEALTH => NewAbilityEnum::DEX,
            self::SURVIVAL => NewAbilityEnum::WIS,
            self::INVESTIGATION => NewAbilityEnum::INT,
            self::ARCANA => NewAbilityEnum::INT,
            self::PERFORMANCE => NewAbilityEnum::CHA,
            self::INTIMIDATION => NewAbilityEnum::CHA,
            self::SLEIGHT_OF_HANDS => NewAbilityEnum::DEX,
        };
    }
}