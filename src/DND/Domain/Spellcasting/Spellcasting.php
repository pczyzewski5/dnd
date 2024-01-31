<?php

namespace DND\Domain\Spellcasting;

use DND\Domain\Character\Character;
use DND\Domain\CharacterClass\CharacterClassHelper;
use DND\Domain\Enum\AbilityEnum;
use DND\Domain\Enum\CharacterClassEnum;

// @todo need total refactor
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
        ],
        CharacterClassEnum::DRUID => [
            9 => [
                ['circle' => 'I', 'count' => 4],
                ['circle' => 'II', 'count' => 3],
                ['circle' => 'III', 'count' => 3],
                ['circle' => 'IV', 'count' => 3],
                ['circle' => 'V', 'count' => 1],
            ],
        ],
        CharacterClassEnum::SORCERER => [
            9 => [
                ['circle' => 'I', 'count' => 4],
                ['circle' => 'II', 'count' => 3],
                ['circle' => 'III', 'count' => 3],
                ['circle' => 'IV', 'count' => 3],
                ['circle' => 'V', 'count' => 1],
            ],
        ]
    ];
    private const CLASS_TO_SPELLCASTING_ABILITY = [
        CharacterClassEnum::PALADIN => AbilityEnum::CHA,
        CharacterClassEnum::SORCERER => AbilityEnum::CHA,
        CharacterClassEnum::DRUID => AbilityEnum::WIS,
    ];

    public function getSpellcastingData(Character $character): array
    {
        $spellcastingAbility = self::CLASS_TO_SPELLCASTING_ABILITY[$this->getCharacterClassName($character)];
        $spellcastingAbilityGeter = 'get' . \ucfirst($spellcastingAbility);
        $spellcastingAbilityMod = $character->getAbilities()->$spellcastingAbilityGeter()->getModifier();

        $halvedCurrentLevel = (int)\floor($character->getLevels()->getLevel() / 2);
        $proficiencyBonus = $character->getProficiencyBonus();

        // @todo changeme
        switch ($this->getCharacterClassName($character)) {
            case CharacterClassEnum::PALADIN:
                $spellCount = $spellcastingAbilityMod + $halvedCurrentLevel;
                break;
            case CharacterClassEnum::DRUID:
                $spellCount = $spellcastingAbilityMod + $character->getLevels()->getLevel();
                break;
            case CharacterClassEnum::SORCERER:
                $spellCount = 10;
                break;
            default:
                $spellCount = 'n/a';
        }

        return [
            'spellAttackMod' => $proficiencyBonus + $spellcastingAbilityMod,
            'spellDC' => 8 + $proficiencyBonus + $spellcastingAbilityMod,
            'spellCount' => \max(1, $spellCount)
        ];
    }

    public function getSpellCircles(Character $character): array
    {
        $levelToSpellCircles = self::LEVEL_TO_SPELL_CIRCLES[$this->getCharacterClassName($character)];
        $result = [];

        foreach ($levelToSpellCircles as $level => $spellCircles) {
            if ($character->getLevels()->getLevel() >= $level) {
                $result = $spellCircles;
                break;
            }
        }

        return $result;
    }

    private function getCharacterClassName(Character $character): string
    {
        $characterClassEnum = $character->getCharacterClassCollection()->getMainClass()->getCharacterClassEnum();

        return CharacterClassHelper::toBaseClass($characterClassEnum)->getValue();
    }
}
