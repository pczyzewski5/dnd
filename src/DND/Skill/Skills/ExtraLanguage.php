<?php

namespace DND\Skill\Skills;

class ExtraLanguage extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'language' => 'uzupłenij mnie'
        ];
    }
}
