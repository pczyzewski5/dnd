<?php

namespace DND\Skill\Skills;

class Expertise extends AbstractSkill
{
    public function getName(): string
    {
        return 'Expertise';
    }

    public function getDescription(): string
    {
        return 'Character level is: ' . $this->character->getActualLevel();
    }
}
