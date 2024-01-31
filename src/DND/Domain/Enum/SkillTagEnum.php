<?php

declare(strict_types=1);

namespace DND\Domain\Enum;

use MyCLabs\Enum\Enum;

class SkillTagEnum extends Enum
{
     const ACTIVE = 'active';
     const PASSIVE = 'passive';
     const USE_COUNT = 'use_count';
     const RESISTANCE = 'resistance';
     const HIDDEN = 'hidden';
}