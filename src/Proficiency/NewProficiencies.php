<?php

namespace App\Proficiency;

use App\Entity\Proficiency;

class NewProficiencies
{
    private array $proficiencies;

    public function __construct(Proficiency ...$proficiencies)
    {
        foreach ($proficiencies as $proficiency) {
            $this->proficiencies[$proficiency->getCategory()][] = $proficiency->getName();
        }

        return $this;
    }

    public function getToolProficiencies(): array
    {
        return $this->proficiencies['tool'] ?? [];
    }

    public function getArmorProficiencies(): array
    {
        return $this->proficiencies['armor'] ?? [];
    }

    public function getWeaponProficiencies(): array
    {
        return $this->proficiencies['weapon'] ?? [];
    }

    public function getAbilitySkillProficiencies(): array
    {
        return $this->proficiencies['ability skill'] ?? [];
    }

    public function getSavingThrowProficiencies(): array
    {
        return $this->proficiencies['saving throw'] ?? [];
    }
}