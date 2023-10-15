<?php

namespace DND\Skill\Skills;

class Evasion extends AbstractSkill
{
    public const ORDER = 300;
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
