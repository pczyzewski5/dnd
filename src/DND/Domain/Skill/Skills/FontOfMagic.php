<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FontOfMagic extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return $this->character->getActualLevel();
    }

    public function getContext(): array
    {
        return [
            'pointsCount' => $this->getUsageCount()
        ];
    }
}
