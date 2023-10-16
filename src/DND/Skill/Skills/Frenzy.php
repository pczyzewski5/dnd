<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Frenzy extends AbstractSkill
{
    public const ORDER = 200;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
