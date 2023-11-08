<?php

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class AuraOfProtection extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'bonus' => \max(1, $this->character->getAbilities()->getCha()->getModifier())
        ];
    }
}
