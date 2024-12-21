<?php

declare(strict_types=1);

namespace App\Skill;

class FinalizedSkill
{
    public function __construct(
        public readonly string $name,
        public readonly string $description
    ) {
    }
}
