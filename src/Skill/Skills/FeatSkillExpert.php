<?php

declare(strict_types=1);

namespace App\Skill\Skills;

class FeatSkillExpert extends AbstractSkill
{
    public function getContext(): array
    {
        return [
            'bonus_ac' => $this->character->getLevels()->getProficiencyBonus()
        ];
    }
}
