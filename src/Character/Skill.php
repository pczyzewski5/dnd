<?php

declare(strict_types=1);

namespace App\Character;

class Skill
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ?int $usageCount = null
    ) {
    }
}
