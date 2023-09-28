<?php

namespace DND\Domain\Enum;

class ProficiencyEnum extends BaseEnum
{
    // saving throws
    const STR = 'str';
    const DEX = 'dex';
    const CON = 'con';
    const INT = 'int';
    const WIS = 'wis';
    const CHA = 'cha';

    // ability skills
    const ACROBATICS = 'acrobatics';
    const ATHLETICS = 'athletics';
    const HISTORY = 'history';
    const INSIGHT = 'insight';
    const MEDICINE = 'medicine';
    const ANIMAL_HANDLING = 'animal handling';
    const DECEPTION = 'deception';
    const PERCEPTION = 'perception';
    const PERSUASION = 'persuasion';
    const NATURE = 'nature';
    const RELIGION = 'religion';
    const STEALTH = 'stealth';
    const SURVIVAL = 'survival';
    const INVESTIGATION = 'investigation';
    const ARCANA = 'arcana';
    const PERFORMANCE = 'performance';
    const INTIMIDATION = 'intimidation';
    const SLEIGHT_OF_HANDS = 'sleight of hands';
}