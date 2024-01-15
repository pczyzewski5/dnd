<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatHeavyArmorMaster extends AbstractSkill
{
    protected const ORDER = 6000;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [];
    }
}
