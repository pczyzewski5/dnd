<?php

namespace DND\Skill\Skills;

class SneakAttack extends AbstractSkill
{
    protected const ORDER = 0;

    public function getContext(): array
    {
        return [
            'sneakAttackDiceCount' => \ceil($this->character->getActualLevel() / 2)
        ];
    }
}