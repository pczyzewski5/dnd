<?php

namespace DND\Domain\Skill\Skills;

class FightingStyleProtection extends AbstractSkill
{
    protected const ORDER = 5000;

    public function getContext(): array
    {
        return [];
    }
}