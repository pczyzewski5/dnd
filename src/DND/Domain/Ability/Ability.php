<?php

namespace DND\Domain\Ability;

class Ability
{
    private int $value;
    private int $modifier;

    public function __construct(int $value)
    {
        $this->value = $value;
        $this->modifier = AbilityScoresModCalculator::calculate($value);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getModifier(): int
    {
        return $this->modifier;
    }

    public function increaseValue(int $value): void
    {
        $this->value += $value;

        $this->modifier = AbilityScoresModCalculator::calculate($this->value);
    }
}
