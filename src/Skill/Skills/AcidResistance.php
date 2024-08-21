<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class AcidResistance extends AbstractSkill
{
    protected const ORDER = 4000;

    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::RESISTANCE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
