<?php

namespace DND\Skill\Skills;

class SneakAttack extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'sneakAttackDiceCount' => \ceil($this->character->getActualLevel() / 2)
        ];
    }
}