<?php

namespace DND\Skill\Skills;

class MindlessRage extends AbstractSkill
{
    public const TYPE = 'active';

    public function getContext(): array
    {
        return [];
    }
}
