<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class AcidBreath extends AbstractSkill
{
    private const LEVEL_TO_DMG = [
        16 => '5k6',
        11 => '4k6',
        6 => '3k6',
        1 => '2k6',
    ];

    protected int $count = 1;
    protected array $tags = [
        SkillTagEnum::ACTIVE,
        SkillTagEnum::USE_COUNT,
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
