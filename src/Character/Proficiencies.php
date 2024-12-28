<?php

namespace App\Character;

use App\Entity\Proficiency;

class Proficiencies
{
    private array $proficiencies;

    public function __construct(Proficiency ...$proficiencies)
    {
        foreach ($proficiencies as $proficiency) {
            $this->proficiencies[$proficiency->getCategory()][] = $proficiency->getName();
        }

        return $this;
    }

    public function getOtherProficiencies(): array
    {
        return $this->proficiencies['other'] ?? [];
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