<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class DivineHealth extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::RESISTANCE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
