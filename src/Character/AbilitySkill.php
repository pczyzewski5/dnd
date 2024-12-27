<?php

declare(strict_types=1);

namespace App\Character;

use App\Enum\AbilitySkillEnum;

class AbilitySkill
{
    public function __construct(
        public readonly AbilitySkillEnum $enum,
        public readonly int $value,
        public readonly bool $hasProficiency
    ) {
    }
}
