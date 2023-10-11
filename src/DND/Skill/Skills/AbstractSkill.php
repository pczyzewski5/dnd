<?php

namespace DND\Skill\Skills;

use DND\Character\Character;

abstract class AbstractSkill
{
    protected Character $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    abstract public function getName(): string;

    abstract public function getDescription(): string;
}
