<?php

namespace DND\Domain\SavingThrows;

use DND\Domain\Ability\Ability;
use DND\Domain\Enum\ProficiencyEnum;
use DND\Domain\Proficiency\Proficiencies;

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
            ProficiencyEnum::from($ability->getAbilityEnum()->getValue())
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