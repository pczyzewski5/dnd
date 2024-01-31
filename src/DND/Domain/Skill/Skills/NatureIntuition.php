<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

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
