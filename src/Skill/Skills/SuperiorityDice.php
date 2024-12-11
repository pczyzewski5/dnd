<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class SuperiorityDice extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return 4;
    }

    public function getContext(): array
    {
        return [];
    }
}
