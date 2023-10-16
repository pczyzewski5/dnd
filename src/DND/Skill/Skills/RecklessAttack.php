<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class RecklessAttack extends AbstractSkill
{
    public const ORDER = 300;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
