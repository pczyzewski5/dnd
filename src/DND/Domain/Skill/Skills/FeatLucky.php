<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatLucky extends AbstractSkill
{
    protected const ORDER = 10000;
    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return 3;
    }

    public function getContext(): array
    {
        return [];
    }
}
