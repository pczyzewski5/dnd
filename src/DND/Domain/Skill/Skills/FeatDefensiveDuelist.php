<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatDefensiveDuelist extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'bonus_ac' => $this->character->getLevels()->getProficiencyBonus()
        ];
    }
}
