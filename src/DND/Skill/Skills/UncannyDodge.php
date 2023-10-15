<?php

namespace DND\Skill\Skills;

class UncannyDodge extends AbstractSkill
{
    public const ORDER = 200;
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
