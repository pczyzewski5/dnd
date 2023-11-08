<?php

namespace DND\Domain\Skill\Skills;

class OathOfTheDevotionPaladinSpells extends AbstractSkill
{
    private const LEVEL_TO_SPELLS = [
        9 => ['promień nadziei', 'rozproszenie magii'],
        5 => ['mniejsze przywrócenie', 'strefa prawdy'],
        3 => ['ochrona przed dobrem i złem', 'sanktuarium'],
    ];

    public function getContext(): array
    {
        $oathSpells = [];

        foreach (self::LEVEL_TO_SPELLS as $level => $spells) {
            if ($this->character->getActualLevel() >= $level) {
                $oathSpells = \array_merge($oathSpells, $spells);
            }
        }

        return [
            'oathSpells' => $oathSpells
        ];
    }
}
