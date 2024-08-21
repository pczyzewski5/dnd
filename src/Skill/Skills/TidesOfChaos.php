<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class TidesOfChaos extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT
    ];

    public function getUsageCount(): int
    {
        return 1;
    }

    public function getContext(): array
    {
        return [];
    }
}
