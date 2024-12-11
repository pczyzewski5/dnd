<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\CharacterClassEnum;
use App\Enum\SkillTagEnum;

class Parry extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE
    ];

    public function getContext(): array
    {
        return ['dex_mod' => $this->character->getAbilities()->getDex()->getModifier()];
    }
}
