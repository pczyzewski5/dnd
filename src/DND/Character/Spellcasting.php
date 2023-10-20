<?php

namespace DND\Character;

use DND\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\AbilityEnum;
use DND\Domain\Enum\CharacterClassEnum;

class Spellcasting
{
    // @todo move to repo?
    private const LEVEL_TO_SPELL_CIRCLES = [
        CharacterClassEnum::PALADIN => [
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
        ]
    ];
    private const CLASS_TO_SPELLCASTING_ABILITY = [
        CharacterClassEnum::PALADIN => AbilityEnum::CHA
    ];

    public function getSpellcastingData(Character $character): array
    {
        $spellcastingAbility = self::CLASS_TO_SPELLCASTING_ABILITY[$this->getCharacterClassName($character)];
        $spellcastingAbilityGeter = 'get' . \ucfirst($spellcastingAbility);
        $spellcastingAbilityMod = $character->getAbilities()->$spellcastingAbilityGeter()->getModifier();

        $halvedCurrentLevel = (int)\floor($character->getActualLevel() / 2);
        $proficiencyBonus = $character->getProficiencyBonus();

        return [
            'spellAttackMod' => $proficiencyBonus + $spellcastingAbilityMod,
            'spellDC' => 8 + $proficiencyBonus + $spellcastingAbilityMod,
            'spellCount' => \max(1, $spellcastingAbilityMod + $halvedCurrentLevel)
        ];
    }

    public function getSpellCircles(Character $character): array
    {
        $levelToSpellCircles = self::LEVEL_TO_SPELL_CIRCLES[$this->getCharacterClassName($character)];
        $result = [];

        foreach ($levelToSpellCircles as $level => $spellCircles) {
            if ($character->getActualLevel() >= $level) {
                $result = $spellCircles;
                break;
            }
        }

        return $result;
    }

    private function getCharacterClassName(Character $character): string
    {
        $characterClassEnum = $character->getCharacterClass()->getCharacterClassEnum();

        return CharacterClassHelper::isArchetype($characterClassEnum)
            ? CharacterClassHelper::getBaseClass($characterClassEnum)->getValue()
            : $characterClassEnum->getValue();
    }
}
