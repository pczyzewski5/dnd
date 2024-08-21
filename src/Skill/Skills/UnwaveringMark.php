<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\Enum\CharacterClassEnum;
use App\Enum\SkillTagEnum;

class UnwaveringMark extends AbstractSkill
{
    protected const ORDER = 4;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];

    public function getUsageCount(): int
    {
        return $this->character->getAbilities()->getStr()->getModifier();
    }

    public function getContext(): array
    {
        $bonusDamage = (int)\floor(
            $this->character->getCharacterClassCollection()->getClassLevel(CharacterClassEnum::FIGHTER) / 2
        );

        return [
            'bonus_damage' => $bonusDamage,
            'count' => $this->getUsageCount()
        ];
    }
}
