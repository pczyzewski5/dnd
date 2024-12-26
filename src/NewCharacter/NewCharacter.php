<?php

declare(strict_types=1);

namespace App\NewCharacter;

use App\Ability\Abilities;
use App\Proficiency\NewProficiencies;

class NewCharacter
{
    public function __construct(
        public readonly string $characterName, // used
        public readonly string $playerName, // used
        public readonly string $campaignName, // used
        public readonly array $hitDices,
        public readonly int $hitPoints,
        public readonly Abilities $abilities,
        public readonly array $simpleLevels,
        public readonly array $skills,
        public readonly array $abilitySkills,
        public readonly string $origin,
        public readonly string $race, // used
        public readonly string $alignment, // used
        public readonly NewProficiencies $proficiencies,
        public readonly array $savingThrows,
        public readonly array $languages,
        public readonly int $passivePerception,
        public readonly int $passiveInsight,
        public readonly int $proficiencyBonus,
        public readonly int $armorClass
    ) {
    }
}
