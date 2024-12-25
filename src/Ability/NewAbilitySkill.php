<?php

declare(strict_types=1);

namespace App\Ability;

use App\Enum\NewAbilitySkillEnum;

class NewAbilitySkill
{
    public function __construct(
        public readonly NewAbilitySkillEnum $enum,
        public readonly int $value,
        public readonly bool $hasProficiency
    ) {
    }
}
