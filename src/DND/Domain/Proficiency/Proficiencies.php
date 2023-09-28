<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class Proficiencies
{
    /** @var ProficiencyEnum[] $proficiencies */
    private array $proficiencies = [];

    public function hasProficiency(ProficiencyEnum $proficiencyEnum): bool
    {
        return \in_array($proficiencyEnum, $this->proficiencies);
    }

    public function addProficiency(ProficiencyEnum $proficiency): void
    {
        $this->proficiencies[] = $proficiency;
    }
}