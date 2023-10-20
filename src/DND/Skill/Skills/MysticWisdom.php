<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class MysticWisdom extends AbstractSkill
{
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
