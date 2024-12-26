<?php

declare(strict_types=1);

namespace App\Level;

use App\Proficiency\NewProficiencies;

class NewLevels
{
    public function __construct(
        public readonly NewProficiencies $proficiencies,
        public readonly int $proficiencyBonus,
        public readonly array $levels,
        public readonly array $hitDices,
        public readonly array $simpleLevels,
        public readonly array $skills
    ) {

    }
}