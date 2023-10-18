<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class MindlessRage extends AbstractSkill
{
    protected const ORDER = 1;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
