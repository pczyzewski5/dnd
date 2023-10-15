<?php

namespace DND\Skill\Skills;

class CunningAction extends AbstractSkill
{
    public const ORDER = 100;
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
