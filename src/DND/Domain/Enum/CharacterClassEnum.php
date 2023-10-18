<?php

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class CharacterClassEnum extends Enum
{
    const BARBARIAN = 'barbarian';
    const BERSERKER = 'berserker';

    const ROUGE = 'rouge';
    const ASSASSIN = 'assassin';

    const DRUID = 'druid';
    const CIRCLE_OF_MOON_DRUID = 'circle of moon druid';
    const RANGER = 'ranger';

    const PALADIN = 'paladin';
    const OATH_OF_THE_ANCIENTS = 'oath of the ancients';

    const SORCERER = 'sorcerer';
    const WILD_MAGIC_SORCERER = 'wild magic sorcerer';
}