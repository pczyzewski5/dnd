<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

class UnarmoredDefense extends AbstractSkill
{
    public function getContext(): array
    {
        return [];
    }
}
