<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class NatureIntuition extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::HIDDEN
    ];

    public function getContext(): array
    {
        return [];
    }
}
