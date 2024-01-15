<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class UncannyDodge extends AbstractSkill
{
    protected const ORDER = 200;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
