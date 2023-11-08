<?php

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class DivineSense extends AbstractSkill
{
    protected CONST TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return  $this->character->getAbilities()->getCha()->getModifier() + 1;
    }

    public function getContext(): array
    {
        return [];
    }
}
