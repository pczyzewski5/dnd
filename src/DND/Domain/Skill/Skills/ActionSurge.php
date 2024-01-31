<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class ActionSurge extends AbstractSkill
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
