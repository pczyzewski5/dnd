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
    const RANGER = 'ranger';

    const PALADIN = 'paladin';
    const OATH_OF_THE_ANCIENTS = 'oath of the ancients';
}