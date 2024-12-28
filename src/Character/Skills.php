<?php

declare(strict_types=1);

namespace App\Character;

use function strtolower;

class Skills
{
    private array $skills;
    private array $skillIndex;

    public function __construct(Skill ...$skills)
    {
        foreach ($skills as $skill) {
            $this->skills[] = $skill;
            $this->skillIndex[] = strtolower($skill->name);
        }

        return $this;
    }

    public function hasSkill(string $name): bool
    {
        return in_array(
            strtolower($name),
            $this->skillIndex
        );
    }

    public function toArray()
    {
        return $this->skills;
    }
}
