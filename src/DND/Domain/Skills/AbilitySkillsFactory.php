<?php

namespace DND\Domain\Skills;

class AbilitySkillsFactory
{
    public static function create(): AbilitySkills
    {
        return new AbilitySkills();
    }
}