<?php

declare(strict_types=1);

namespace App\Service;

use App\Enum\AbilitySkillEnum;

class AbilitySkillService
{
    private readonly array $abilitySkills;

    public function __construct()
    {
        $this->abilitySkills = array_map(
            fn(AbilitySkillEnum $enum): string => $enum->value,
            AbilitySkillEnum::cases()
        );
    }

    /**
     * @param string[] $given
     */
    public function extractAbilitySkills(array $given): array
    {
        return array_intersect($this->abilitySkills, $given);
    }
}
