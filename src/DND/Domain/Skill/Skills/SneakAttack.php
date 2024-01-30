<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class SneakAttack extends AbstractSkill
{
    protected const ORDER = 0;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];

    public function getContext(): array
    {
        return [
            'sneakAttackDiceCount' => \ceil($this->character->getLevels()->getLevel() / 2)
        ];
    }
}