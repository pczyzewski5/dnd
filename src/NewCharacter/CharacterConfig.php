<?php

declare(strict_types=1);

namespace App\NewCharacter;

use App\Ability\AbilitiesConfig;

class CharacterConfig
{
    public function __construct(
        public readonly string $characterName,
        public readonly string $playerName,
        public readonly string $campaignName,
        public readonly string $alignment,
        public readonly string $race,
        public readonly string $origin,
        public readonly array $levelConfigs,
        public readonly AbilitiesConfig $abilitiesConfig,
    ) {

    }
}
