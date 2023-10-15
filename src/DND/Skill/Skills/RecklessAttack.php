<?php

namespace DND\Skill\Skills;

class RecklessAttack extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
