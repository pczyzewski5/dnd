<?php

namespace DND\Domain\Ability;

use DND\Domain\Enum\AbilityEnum;

class Ability
{
    private AbilityEnum $abilityEnum;
    private int $value;
    private int $modifier;

    public function __construct(AbilityEnum $abilityEnum, int $value)
    {
        $this->abilityEnum = $abilityEnum;
        $this->value = $value;

        $this->modifier = AbilityScoresModCalculator::calculate($value);
    }

    public function getAbilityEnum(): AbilityEnum
    {
        return $this->abilityEnum;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getModifier(): int
    {
        return $this->modifier;
    }
}
