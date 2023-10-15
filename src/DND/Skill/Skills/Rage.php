<?php

namespace DND\Skill\Skills;

class Rage extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
