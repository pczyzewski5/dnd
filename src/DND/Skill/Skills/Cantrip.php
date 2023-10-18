<?php

namespace DND\Skill\Skills;

class Cantrip extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'cantripName' => 'uzupełnij mnie'
        ];
    }
}
