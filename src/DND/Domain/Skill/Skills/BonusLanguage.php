<?php

namespace DND\Domain\Skill\Skills;

class BonusLanguage extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'language' => 'uzupłenij mnie'
        ];
    }
}
