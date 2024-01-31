<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class HungryJaws extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return $this->character->getLevels()->getProficiencyBonus();
    }

    public function getContext(): array
    {
       return [
           'bonus_hp' => $this->getUsageCount(),
       ];
    }
}
