<?php

namespace DND\Skill\Skills;

class Evasion extends AbstractSkill
{
    protected const ORDER = 300;

    public function getContext(): array
    {
        return [];
    }
}
