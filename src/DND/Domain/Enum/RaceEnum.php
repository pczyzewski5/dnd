<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class RaceEnum extends Enum
{
    const HALFLING = 'halfling';
    const LIGHTFOOT_HALFLING = 'lightfoot halfling';

    const HUMAN = 'human';
    const HUMAN_VARIANT = 'human variant';

    const DRAGONBORN = 'dragonborn';
    const COPPER_DRAGONBORN = 'copper dragonborn';

    const TIEFLING = 'tiefling';

    const ELF = 'elf';
    const HIGH_ELF = 'high elf';

    const LIZARDFOLK = 'lizardfolk';
}