<?php

namespace DND\Skill\Skills;

class DangerSense extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
