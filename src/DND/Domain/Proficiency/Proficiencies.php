<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class Proficiencies
{
    private array $proficiencies = [];

    public function hasProficiency(ProficiencyEnum $proficiencyEnum): bool
    {
        return \in_array($proficiencyEnum->getValue(), $this->proficiencies);
    }

    public function addProficiency(ProficiencyEnum $proficiency): void
    {
        $this->proficiencies[] = $proficiency->getValue();
    }

    public function addProficiencies(array $proficiencies): void
    {
        foreach ($proficiencies as $proficiency) {
            $this->addProficiency($proficiency);
        }
    }
}