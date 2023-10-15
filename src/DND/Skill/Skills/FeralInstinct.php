<?php

namespace DND\Skill\Skills;

class FeralInstinct extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
