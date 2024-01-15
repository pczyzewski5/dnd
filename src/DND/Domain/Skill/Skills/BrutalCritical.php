<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class BrutalCritical extends AbstractSkill
{
    protected const ORDER = 4;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
