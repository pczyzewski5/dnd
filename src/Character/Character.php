<?php

declare(strict_types=1);

namespace App\Character;

class Character
{
    public function __construct(
        public readonly Abilities $abilities,
        public readonly string $characterName, // used
        public readonly string $playerName, // used
        public readonly string $campaignName, // used
        public readonly string $origin,
        public readonly string $race, // used
        public readonly Proficiencies $proficiencies,
        public readonly array $hitDices,
        public readonly array $simpleLevels,
        public readonly int $proficiencyBonus,
        public readonly int $hitPoints,
        public readonly array $skills,
        public readonly array $abilitySkills,
        public readonly array $savingThrows,
        public readonly int $passivePerception,
        public readonly int $passiveInsight,
        public readonly int $armorClass,
        public readonly int $speed,
        public readonly array $languages,
        public readonly int $darkvision,
        public readonly string $alignment, // used
        public readonly int $initiative
    ) {
    }
}
