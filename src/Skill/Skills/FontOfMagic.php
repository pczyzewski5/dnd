<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class FontOfMagic extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return $this->character->getLevels()->getLevel();
    }

    public function getContext(): array
    {
        return [
            'pointsCount' => $this->getUsageCount()
        ];
    }
}
