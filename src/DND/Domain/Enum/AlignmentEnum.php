<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class AlignmentEnum extends Enum
{
    const LAWFUL_GOOD = 'lawful good';
    const CHAOTIC_GOOD = 'chaotic good';
    const NEUTRAL_GOOD = 'neutral good';
    const LAWFUL_NEUTRAL = 'lawful neutral';
    const CHAOTIC_NEUTRAL = 'chaotic neutral';
    const NEUTRAL = 'neutral';
    const LAWFUL_EVIL = 'lawful evil';
    const CHAOTIC_EVIL = 'chaotic evil';
    const NEUTRAL_EVIL = 'neutral evil';
}