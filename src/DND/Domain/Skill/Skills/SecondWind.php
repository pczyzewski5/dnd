<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\CharacterClassEnum;
use DND\Domain\Enum\SkillTagEnum;

class SecondWind extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return 1;
    }

    public function getContext(): array
    {
       return [];
    }
}
