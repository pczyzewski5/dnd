<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class Proficiencies
{
    private array $proficiencies = [];
    private array $expertProficiencies = [];

    public function hasProficiency(ProficiencyEnum $proficiencyEnum): bool
    {
        return \in_array($proficiencyEnum->getValue(), $this->proficiencies);
    }

    public function hasExpertise(ProficiencyEnum $proficiencyEnum): bool
    {
        return \in_array($proficiencyEnum->getValue(), $this->expertProficiencies);
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

    public function addExpertProficiency(ProficiencyEnum $proficiency): void
    {
        $this->expertProficiencies[] = $proficiency->getValue();
    }
}