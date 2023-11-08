<?php

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class CircleForms extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'CR' => $this->character->getActualLevel() >= 6
                ? (int)\floor($this->character->getActualLevel() / 3)
                : 1
        ];
    }
}
