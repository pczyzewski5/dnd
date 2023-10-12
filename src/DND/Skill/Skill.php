<?php

namespace DND\Skill;

class Skill
{
    private string $name;
    private
    ?int $level;

    public function __construct(string $name, ?int $level = null)
    {
        $this->name = $name;
        $this->level = $level;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLevel(): ?int
    {
        return $this->level ?? null;
    }
}
