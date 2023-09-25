<?php

namespace DND\Domain\Ability;

class AbilitiesFactory
{
    public static function create(): Abilities
    {
        return new Abilities(
            10,
            11,
            12,
            13,
            14,
            15
        );
    }
}