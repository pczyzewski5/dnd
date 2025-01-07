<?php

declare(strict_types=1);

namespace App\Builder\SkillBuilder;

use App\Character\Abilities;
use App\Character\Skill;
use App\Entity\Level;


use function str_replace;

abstract class AbstractSkillFinisher
{
    protected Abilities $abilities;
    protected int $proficiencyBonus;

    private array $skillIndex;
    private array $levels;

    abstract public function supports(Skill $skill): bool;

    abstract public function finish(Skill $skill): Skill;

    public function setup(
        Abilities $abilities,
        int $proficiencyBonus,
        array $skillIndex,
        array $levels
    ): self {
        $this->abilities = $abilities;
        $this->proficiencyBonus = $proficiencyBonus;
        $this->skillIndex = $skillIndex;
        $this->levels = $levels;

        return $this;
    }

    protected function getLevel(string $characterClass = null): int
    {
        $result = 0;

        /** @var Level $level */
        foreach ($this->levels as $level) {
            if ($level->getCharacterClass()->getName() === $characterClass
                || null === $characterClass
            ) {
                $result++;
            }
        }

        return $result;
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
