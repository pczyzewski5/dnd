<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class BendLuck extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
