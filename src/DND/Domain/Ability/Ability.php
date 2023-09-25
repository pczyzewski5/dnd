<?php

namespace DND\Domain\Ability;

use DND\Domain\MergerTrait;

class Ability
{
    public function getValue(): int
    {
        return 10;
    }

    public function getModifier(): int
    {
        return 2;
    }
}