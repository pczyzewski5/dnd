<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class AcidResistance extends AbstractSkill
{
    protected const ORDER = 4000;

    protected const TAGS = [
        SkillTagEnum::PASSIVE,
        SkillTagEnum::RESISTANCE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
