<?php

namespace DND\Skill\Skills;

class FightingStyle extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'fightingStyle' => 'uzupełnij mnie'
        ];
    }
}
