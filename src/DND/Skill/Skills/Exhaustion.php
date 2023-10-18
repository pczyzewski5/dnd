<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Exhaustion extends AbstractSkill
{
    protected const ORDER = 10000;
    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getContext(): array
    {
        return [];
    }
}
