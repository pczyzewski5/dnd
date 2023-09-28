<?php

namespace DND\Domain\Skills;

class AbilitySkill
{
    public function getValue(): int
    {
        return 3;
    }

    public function hasProficiency(): bool
    {
        return true;
    }
}