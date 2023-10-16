<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Exhaustion extends AbstractSkill
{
    public const ORDER = 1100;

    protected int $count = 6;
    protected array $tags = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getContext(): array
    {
        return [];
    }
}
