<?php

namespace DND\Skill\Skills;

class CunningAction extends AbstractSkill
{
    protected const ORDER = 100;

    public function getContext(): array
    {
        return [];
    }
}
