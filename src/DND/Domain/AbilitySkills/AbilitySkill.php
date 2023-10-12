<?php

namespace DND\Domain\AbilitySkills;

use DND\Domain\Ability\Ability;
use DND\Domain\Enum\AbilityEnum;
use DND\Domain\Enum\AbilitySkillEnum;
use DND\Domain\Proficiency\Proficiencies;

class AbilitySkill
{
    private Ability $ability;
    private int $proficiencyBonus;
    private bool $hasProficiency;
    private bool $hasExpertise;

    public function __construct(
        AbilitySkillEnum $abilitySkillEnum,
        Proficiencies $proficiencies,
        Ability $ability,
        int $proficiencyBonus
    ) {
        $this->ability = $ability;
        $this->proficiencyBonus = $proficiencyBonus;

        $this->hasProficiency = $proficiencies->hasProficiency($abilitySkillEnum->getValue());
        $this->hasExpertise = $proficiencies->hasExpertise($abilitySkillEnum->getValue());
    }

    public function getAbilityEnum(): AbilityEnum
    {
        return $this->ability->getAbilityEnum();
    }

    public function getValue(): int
    {
        $value = $this->ability->getModifier();

        if ($this->hasProficiency) {
            $value += $this->proficiencyBonus;
            if ($this->hasExpertise) {
                $value += $this->proficiencyBonus;
            }
        }

        return $value;
    }

    public function hasProficiency(): bool
    {
        return $this->hasProficiency || $this->hasExpertise;
    }
}