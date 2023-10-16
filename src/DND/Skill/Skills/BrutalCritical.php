<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class BrutalCritical extends AbstractSkill
{
    public const ORDER = 4;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
