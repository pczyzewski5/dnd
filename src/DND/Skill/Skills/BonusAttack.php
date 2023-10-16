<?php

namespace DND\Skill\Skills;

class BonusAttack extends AbstractSkill
{
    public const ORDER = 5000;

    public function getContext(): array
    {
        return [
            'level' => $this->character->getActualLevel()
        ];
    }
}
