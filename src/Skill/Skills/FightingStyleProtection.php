<?php

declare(strict_types=1);

namespace App\Skill\Skills;

class FightingStyleProtection extends AbstractSkill
{
    protected const ORDER = 5000;

    public function getContext(): array
    {
        return [];
    }
}
