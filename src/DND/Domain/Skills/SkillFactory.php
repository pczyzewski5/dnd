<?php

namespace DND\Domain\Skills;

class SkillFactory
{
    public static function create(): Skills
    {
        return new Skills();
    }
}