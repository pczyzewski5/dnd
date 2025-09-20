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
}
