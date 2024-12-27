<?php

declare(strict_types=1);

namespace App\Enum;

enum AbilitySkillEnum: string
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

    public function getAbilityEnum(): AbilityEnum
    {
        return match ($this) {
            self::ACROBATICS => AbilityEnum::DEX,
            self::ATHLETICS => AbilityEnum::STR,
            self::HISTORY => AbilityEnum::INT,
            self::INSIGHT => AbilityEnum::WIS,
            self::MEDICINE => AbilityEnum::WIS,
            self::ANIMAL_HANDLING => AbilityEnum::WIS,
            self::DECEPTION => AbilityEnum::CHA,
            self::PERCEPTION => AbilityEnum::WIS,
            self::PERSUASION => AbilityEnum::CHA,
            self::NATURE => AbilityEnum::INT,
            self::RELIGION => AbilityEnum::INT,
            self::STEALTH => AbilityEnum::DEX,
            self::SURVIVAL => AbilityEnum::WIS,
            self::INVESTIGATION => AbilityEnum::INT,
            self::ARCANA => AbilityEnum::INT,
            self::PERFORMANCE => AbilityEnum::CHA,
            self::INTIMIDATION => AbilityEnum::CHA,
            self::SLEIGHT_OF_HANDS => AbilityEnum::DEX,
        };
    }
}