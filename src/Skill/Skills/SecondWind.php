<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\CharacterClassEnum;
use App\Enum\SkillTagEnum;

class SecondWind extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return 1;
    }

    public function getContext(): array
    {
       return [
           'bonus_hp' => $this->character->getCharacterClassCollection()->getClassLevel(CharacterClassEnum::FIGHTER)
       ];
    }
}
