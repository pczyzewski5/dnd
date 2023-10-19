<?php

namespace DND\Skill\Skills;

use DND\Domain\Enum\SkillTagEnum;

class PaladinSpellcasting extends AbstractSkill
{
    protected const ORDER = 2;
    protected const TAGS = [
        SkillTagEnum::ACTIVE,
    ];
    private const LEVEL_TO_SPELL_CIRCLES = [
        9 => [
            ['circle' => 'I', 'count' => 4],
            ['circle' => 'II', 'count' => 3],
            ['circle' => 'III', 'count' => 2],
        ],
        7 => [
            ['circle' => 'I', 'count' => 4],
            ['circle' => 'II', 'count' => 3]
        ],
        5 => [
            ['circle' => 'I', 'count' => 4],
            ['circle' => 'II', 'count' => 2],
        ],
        3 => [
            ['circle' => 'I', 'count' => 3]
        ],
        2 => [
            ['circle' => 'I', 'count' => 2]
        ]
    ];

    public function getContext(): array
    {
        $proficiencyBonus = $this->character->getProficiencyBonus();
        $chaMod = $this->character->getAbilities()->getCha()->getModifier();
        $actualLevel = $this->character->getActualLevel();

        $spellCount = $chaMod + (int)\floor($actualLevel / 2) + $chaMod;

        foreach (self::LEVEL_TO_SPELL_CIRCLES as $level => $spellCircles) {
            if ($actualLevel >= $level) {
                break;
            }
        }

        return [
            'spellDC' => 8 + $proficiencyBonus + $chaMod,
            'spellAttackMod' => $proficiencyBonus + $chaMod,
            'spellCount' => \max(1, $spellCount),
            'spellCircles' => $spellCircles
        ];
    }
}
