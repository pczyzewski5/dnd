<?php

namespace DND\Skill\Skills;

class Evasion extends AbstractSkill
{
    public const ORDER = 300;

    public function getContext(): array
    {
        return [];
    }
}
