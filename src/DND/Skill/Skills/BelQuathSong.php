<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class BelQuathSong extends AbstractSkill
{
    public const ORDER = 500;
    protected int $count = 1;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getContext(): array
    {
        return [];
    }
}
