<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class HellishResistance extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::RESISTANCE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
