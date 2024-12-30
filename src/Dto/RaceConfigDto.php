<?php

declare(strict_types=1);

namespace App\Dto;

class RaceConfigDto
{
    public function __construct(
        public readonly array $asi,
        public readonly array $languages,
        public readonly int $speed,
        public readonly int $darkvision,
    ) {
    }
}
