<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class MindlessRage extends AbstractSkill
{
    public const ORDER = 400;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
