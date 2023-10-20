<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Spellcasting extends AbstractSkill
{
    protected const ORDER = 2;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'spellCircles' => $this->character->getSpellCircles()
        ];
    }
}
