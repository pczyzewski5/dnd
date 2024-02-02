<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class CharacterClassEnum extends Enum
{
    const BARBARIAN = 'barbarian';
    const BERSERKER = 'berserker';
    const PATH_OF_THE_TOTEM_WARRIOR = 'path of the totem warrior';
    const PATH_OF_THE_ANCESTRAL_GUARDIAN = 'path of the ancestral guardian';

    const BARD = 'bard';

    const CLERIC = 'cleric';

    const DRUID = 'druid';
    const CIRCLE_OF_MOON_DRUID = 'circle of moon druid';

    const FIGHTER = 'fighter';
    const CAVALIER = 'cavalier';
    const BATTLE_MASTER = 'battle master';
    const ELDRITCH_KNIGHT = 'eldritch knight';

    const MONK = 'monk';

    const PALADIN = 'paladin';
    const OATH_OF_THE_ANCIENTS_PALADIN = 'oath of the ancients paladin';

    const RANGER = 'ranger';

    const ROUGE = 'rouge';

    const ASSASSIN = 'assassin';

    const SORCERER = 'sorcerer';
    const WILD_MAGIC_SORCERER = 'wild magic sorcerer';

    const WARLOCK = 'warlock';

    const WIZARD = 'wizard';
}