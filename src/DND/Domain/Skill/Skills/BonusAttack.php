<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

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
