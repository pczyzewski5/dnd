<?php

declare(strict_types=1);

namespace App\Race;

class RaceConfig
{
    public function __construct(
        public readonly array $asi
    ) {
    }
}
