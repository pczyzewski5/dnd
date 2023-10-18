<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class BelQuathSong extends AbstractSkill
{
    protected const ORDER = 500;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
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
