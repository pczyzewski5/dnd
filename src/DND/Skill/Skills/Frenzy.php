<?php

namespace DND\Skill\Skills;

class Frenzy extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
