<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Frenzy extends AbstractSkill
{
    protected const ORDER = 2;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
