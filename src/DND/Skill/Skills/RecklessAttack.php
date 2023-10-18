<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class RecklessAttack extends AbstractSkill
{
    protected const ORDER = 3;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
