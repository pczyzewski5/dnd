<?php

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class ProficiencyEnum extends Enum
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

    // armors
    const LIGHT_ARMORS = 'light armors';
    const MEDIUM_ARMORS = 'medium armors';
    const HEAVY_ARMORS = 'heavy armors';
    const SHIELDS = 'shields';

    // weapons
    const SIMPLE_WEAPONS = 'simple weapons';
    const MARTIAL_WEAPONS = 'martial weapons';
    const LONG_SWORD = 'long sword';
    const SHORT_SWORD = 'short sword';
    const SHORT_BOW = 'short bow';
    const LONG_BOW = 'long bow';
    const RAPIER = 'rapier';
    const HAND_CROSSBOW = 'hand crossbow';
    const LIGHT_CROSSBOW = 'light crossbow';
    const DAGGER = 'dagger';
    const DART = 'dart';
    const ROD = 'rod';
    const SLING = 'sling';
    CONST MACE = 'mace';
    CONST JAVELIN = 'javelin';
    CONST CLUB = 'club';
    CONST SCIMITAR = 'scimitar';
    CONST SICKLE = 'sickle';
    CONST SPEAR = 'spear';

    // tools
    const THIEF_TOOLS = 'thief tools';
    const TINKER_TOOLS = 'tinker tools';

    // kits
    const HERBALISM_KIT = 'herbalism kit';

    // vehicles
    const LAND_VEHICLES = 'land vehicles';
}