<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

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
