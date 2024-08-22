<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class RecklessAttack extends AbstractSkill
{
    protected const ORDER = 3;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
