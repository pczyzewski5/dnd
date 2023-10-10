<?php

namespace DND\Domain\Proficiency;

use DND\Domain\Enum\ProficiencyEnum;

class Proficiencies
{
    private array $proficiencies = [];
    private array $expertProficiencies = [];

    public function getProficiencies(): array
    {
        return $this->proficiencies;
    }

    public function hasProficiency(ProficiencyEnum|string $proficiency): bool
    {
        if ($proficiency instanceof ProficiencyEnum) {
            $proficiency = $proficiency->getValue();
        }

        return \in_array($proficiency, $this->proficiencies);
    }

    public function hasExpertise(ProficiencyEnum|string $proficiency): bool
    {
        if ($proficiency instanceof ProficiencyEnum) {
            $proficiency = $proficiency->getValue();
        }

        return \in_array($proficiency, $this->expertProficiencies);
    }

    public function addProficiency(ProficiencyEnum $proficiency): void
    {
        $this->proficiencies[] = $proficiency->getValue();
    }

    public function addExpertProficiency(ProficiencyEnum $proficiency): void
    {
        $this->expertProficiencies[] = $proficiency->getValue();
    }

    public function merge(Proficiencies $proficiencies): void
    {
        $this->proficiencies = \array_merge($this->proficiencies, $proficiencies->getProficiencies());
    }
}