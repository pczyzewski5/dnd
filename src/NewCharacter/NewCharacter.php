<?php

declare(strict_types=1);

namespace App\NewCharacter;

use App\Ability\NewAbilities;

class NewCharacter
{
    public function __construct(
        public readonly string $characterName,
        public readonly string $playerName,
        public readonly string $campaignName,
        public readonly array $hitDices,
        public readonly int $hitPoints,
        public readonly NewAbilities $abilities,
        public readonly array $levels,
        public readonly array $skills,
        public readonly string $origin,
        public readonly string $race,
        public readonly array $armorProficiencies,
        public readonly array $weaponProficiencies,
        public readonly array $toolProficiencies,
        public readonly array $savingThrowProficiencies,
        public readonly array $skillProficiencies,
    ) {
    }
}
