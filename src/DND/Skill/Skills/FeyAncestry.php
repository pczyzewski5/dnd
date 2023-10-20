<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeyAncestry extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
