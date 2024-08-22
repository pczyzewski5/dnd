<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class LayOnHands extends AbstractSkill
{
    protected const ORDER = 4;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return $this->character->getLevels()->getLevel() * 5;
    }

    public function getContext(): array
    {
        return [
            'pointsCount' => $this->getUsageCount()
        ];
    }
}
