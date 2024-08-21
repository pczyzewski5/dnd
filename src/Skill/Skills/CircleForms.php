<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class CircleForms extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'CR' => $this->character->getLevels()->getLevel() >= 6
                ? (int)\floor($this->character->getLevels()->getLevel() / 3)
                : 1
        ];
    }
}
