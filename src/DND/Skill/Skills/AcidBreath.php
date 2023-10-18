<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class AcidBreath extends AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
    ];
    private const LEVEL_TO_DMG = [
        16 => '5k6',
        11 => '4k6',
        6 => '3k6',
        1 => '2k6',
    ];

    public function getContext(): array
    {
        foreach (self::LEVEL_TO_DMG as $level => $dmg) {
            if ($this->character->getActualLevel() >= $level) {
                break;
            }
        }

        return [
            'dmg' => $dmg,
            'dc' => 8 + $this->character->getAbilities()->getCon()->getModifier() + $this->character->getProficiencyBonus()
        ];
    }
}
