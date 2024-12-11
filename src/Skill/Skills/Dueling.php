<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\SkillTagEnum;

class Dueling extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::PASSIVE
    ];

    public function getContext(): array
    {
        return [];
    }
}
