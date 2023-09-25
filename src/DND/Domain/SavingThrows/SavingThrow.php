<?php

namespace DND\Domain\SavingThrows;

class SavingThrow
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