<?php

declare(strict_types=1);

namespace App\Level;

class LevelConfig
{
    public function __construct(
        public readonly int $level,
        public readonly string $class,
        public readonly array $skills,
        public readonly array $proficiencies,
    ) {

    }
}