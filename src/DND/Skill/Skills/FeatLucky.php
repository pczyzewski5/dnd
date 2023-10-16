<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatLucky extends AbstractSkill
{
    protected int $count = 3;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getContext(): array
    {
        return [];
    }
}
