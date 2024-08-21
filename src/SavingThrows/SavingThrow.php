<?php

namespace App\SavingThrows;

use App\Ability\Ability;
use App\Proficiency\Proficiencies;

class SavingThrow
{
    private Ability $ability;
    private int $proficiencyBonus;
    private bool $hasProficiency;

    public function __construct(
        Ability $ability,
        Proficiencies $proficiencies,
        int $proficiencyBonus
    ) {
        $this->ability = $ability;
        $this->proficiencyBonus = $proficiencyBonus;

        $this->hasProficiency = $proficiencies->hasProficiency(
            $ability->getAbilityEnum()->getValue()
        );
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