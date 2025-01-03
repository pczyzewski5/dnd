<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Abilities;
use App\Character\Skill;

use function str_replace;

abstract class AbstractSkillFinisher
{
    protected Abilities $abilities;
    protected int $level;

    private array $skillIndex;

    abstract public function supports(Skill $skill): bool;

    abstract public function finish(Skill $skill): Skill;

    public function setup(
        Abilities $abilities,
        array $skillIndex,
        int $level
    ): self {
        $this->abilities = $abilities;
        $this->skillIndex = $skillIndex;
        $this->level = $level;

        return $this;
    }

    protected function hasSkill(string $name): bool
    {
        return in_array($name, $this->skillIndex);
    }

    protected function replacePlaceholders(array $context, string $description): string
    {
        foreach ($context as $placeholder => $value) {
            $description = str_replace('{{ ' . $placeholder . ' }}', (string) $value, $description);
        }

        return $description;
    }
}
