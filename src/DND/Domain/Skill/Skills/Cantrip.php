<?php

namespace DND\Domain\Skill\Skills;

class Cantrip extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'cantripName' => 'uzupełnij mnie'
        ];
    }
}
