<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class CunningAction extends AbstractSkill
{
    protected const ORDER = 100;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
