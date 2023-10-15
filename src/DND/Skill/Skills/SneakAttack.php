<?php

namespace DND\Skill\Skills;

class SneakAttack extends AbstractSkill
{
    public const ORDER = 0;
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [
            'sneakAttackDiceCount' => \ceil($this->character->getActualLevel() / 2)
        ];
    }
}