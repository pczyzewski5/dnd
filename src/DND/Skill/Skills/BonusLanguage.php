<?php

namespace DND\Skill\Skills;

class BonusLanguage extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'language' => 'uzupłenij mnie'
        ];
    }
}
