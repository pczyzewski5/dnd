<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class FeatSkillExpert extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'bonus_ac' => $this->character->getLevels()->getProficiencyBonus()
        ];
    }
}
