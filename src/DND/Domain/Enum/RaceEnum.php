<?php

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class RaceEnum extends Enum
{
    const HUMAN = 'human';
    const TIEFLING = 'tiefling';
    const ORC = 'orc';

    const LIGHTFOOT_HALFLING = 'lightfoot halfling';

    const DRAGONBORN = 'dragonborn';
    const COPPER_DRAGONBORN = 'copper dragonborn';

    const ELF = 'elf';
    const HIGH_ELF = 'high elf';
}