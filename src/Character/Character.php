<?php

declare(strict_types=1);

namespace App\Character;

class Character
{
    public function __construct(
        public readonly Abilities $abilities,
        public readonly string $characterName,
        public readonly string $playerName,
        public readonly string $campaignName,
        public readonly string $origin,
        public readonly string $race,
        public readonly Proficiencies $proficiencies,
        public readonly array $hitDices,
        public readonly array $simpleLevels,
        public readonly int $proficiencyBonus,
        public readonly int $hitPoints,
        public readonly Skills $skills,
        public readonly array $abilitySkills,
        public readonly array $savingThrows,
        public readonly int $passivePerception,
        public readonly int $passiveInsight,
        public readonly int $armorClass,
        public readonly int $speed,
        public readonly array $languages,
        public readonly int $darkvision,
        public readonly string $alignment,
        public readonly int $initiative,
        public readonly int $attackCount,
        public readonly array $resistances,
        public readonly string $meta,
        public readonly ?Spellcasting $spellcasting,
    ) {
    }
}
