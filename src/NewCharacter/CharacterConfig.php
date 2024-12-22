<?php

declare(strict_types=1);

namespace App\NewCharacter;

use App\Ability\NewAbilities;
use App\Collection\Levels;
use App\Entity\Origin;
use App\Entity\Race;

class CharacterConfig
{
    public function __construct(
        public readonly string $characterName,
        public readonly string $playerName,
        public readonly string $campaignName,
        public readonly string $alignment,
        public readonly Levels $levels,
        public readonly Race $race,
        public readonly Origin $origin,
        public readonly NewAbilities $abilities,
    ) {

    }
}
