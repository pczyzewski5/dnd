<?php

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Brave extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
