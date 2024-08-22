<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class FeatSentinel extends AbstractSkill
{
    protected const ORDER = 6001;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
