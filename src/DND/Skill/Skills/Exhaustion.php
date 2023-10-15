<?php

namespace DND\Skill\Skills;

class Exhaustion extends AbstractSkill
{
    public const ORDER = 1100;
    public const TYPE = 'passive';

    public function getContext(): array
    {
        return [];
    }
}
