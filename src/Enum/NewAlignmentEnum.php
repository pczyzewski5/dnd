<?php

declare(strict_types=1);

namespace App\Enum;

use MyCLabs\Enum\Enum;

enum NewAlignmentEnum: string
{
    case LAWFUL_GOOD = 'lawful good';
    case CHAOTIC_GOOD = 'chaotic good';
    case NEUTRAL_GOOD = 'neutral good';
    case LAWFUL_NEUTRAL = 'lawful neutral';
    case CHAOTIC_NEUTRAL = 'chaotic neutral';
    case NEUTRAL = 'neutral';
    case LAWFUL_EVIL = 'lawful evil';
    case CHAOTIC_EVIL = 'chaotic evil';
    case NEUTRAL_EVIL = 'neutral evil';
}