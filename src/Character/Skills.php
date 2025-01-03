<?php

declare(strict_types=1);

namespace App\Character;

use function strtolower;

class Skills
{
    private array $skills;
    private array $usageCountSkills;
    private array $skillIndex;

    public function __construct(Skill ...$skills)
    {
        $this->skills = [];
        $this->usageCountSkills = [];

        foreach ($skills as $skill) {
            $skill->usageCount === null || $this->usageCountSkills[] = $skill;

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

    public function all(): array
    {
        return $this->skills;
    }

    public function withUsageCount(): array
    {
        return $this->usageCountSkills;
    }
}
