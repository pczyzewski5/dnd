<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class Proficiencies
{
    /** @var ProficiencyEnum[] $proficiencies */
    private array $savingThrowsProficiencies = [];

    public function hasProficiency(ProficiencyEnum $proficiencyEnum): bool
    {
        return \in_array($proficiencyEnum, $this->savingThrowsProficiencies);
    }

    public function addSavingThrowProficiency(ProficiencyEnum $proficiency): void
    {
        $this->savingThrowsProficiencies[] = $proficiency;
    }
}