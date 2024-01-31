<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class Bite extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE
    ];

    public function getContext(): array
    {
        return [
            'bonus_dmg' => $this->character->getAbilities()->getStr()->getModifier(),
            'attack_mod' => $this->character->getAbilities()->getStr()->getModifier()
                + $this->character->getLevels()->getProficiencyBonus()
        ];
    }
}
