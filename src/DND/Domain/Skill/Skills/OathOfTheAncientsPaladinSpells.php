<?php

namespace DND\Domain\Skill\Skills;

class OathOfTheAncientsPaladinSpells extends AbstractSkill
{
    private const LEVEL_TO_SPELLS = [
        9 => ['ochrona przed energią', 'rozrost roślin'],
        5 => ['krok przez mgłę', 'księżycowy promień'],
        3 => ['pętające uderzenie', 'rozmawianie ze zwierzętami'],
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
