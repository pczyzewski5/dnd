<?php

namespace DND\Character;

class Level
{
    public function getLevel(): int
    {
        return 8;
    }

    public function getClass(): string
    {
        // @todo change to enum
        return 'barbarian';
    }
}