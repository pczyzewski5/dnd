<?php

namespace DND\Domain\AbilitySkills;

use DND\Domain\Ability\Ability;

class AbilitySkill
{
    private Ability $ability;
    private bool $hasProficiency;
    private int $proficiencyBonus;

    public function __construct(
        Ability $ability,
        bool $hasProficiency,
        int $proficiencyBonus
    ) {
        $this->ability = $ability;
        $this->hasProficiency = $hasProficiency;
        $this->proficiencyBonus = $proficiencyBonus;
    }

    public function getValue(): int
    {
        $value = $this->ability->getModifier();

        if ($this->hasProficiency) {
            $value += $this->proficiencyBonus;
        }

        return $value;
    }

    public function hasProficiency(): bool
    {
        return $this->hasProficiency;
    }
}