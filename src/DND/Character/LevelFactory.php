<?php

namespace DND\Character;

class LevelFactory
{
    public static function fromArray(array $levels): Levels
    {
        return new Levels($levels);
    }
}