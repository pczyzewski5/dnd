<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatGreatWeaponMaster extends AbstractSkill
{
    protected array $tags = [
        SkillTagEnum::ACTIVE,
    ];


    public function getContext(): array
    {
        return [];
    }
}