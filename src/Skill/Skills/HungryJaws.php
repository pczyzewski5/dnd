<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

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
