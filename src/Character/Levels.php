<?php

declare(strict_types=1);

namespace App\Character;

class Levels
{
    public function __construct(
        public readonly Proficiencies $proficiencies,
        public readonly int $proficiencyBonus,
        public readonly array $levels,
        public readonly array $hitDices,
        public readonly array $simpleLevels,
        public readonly array $skills
    ) {

    }
}