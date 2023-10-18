<?php

namespace DND\Skill\Skills;

class BonusAttack extends AbstractSkill
{
    protected const ORDER = 5000;

    public function getContext(): array
    {
        return [
            'level' => $this->grantLevel
        ];
    }
}
