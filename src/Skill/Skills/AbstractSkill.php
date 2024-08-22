<?php

declare(strict_types=1);

namespace App\Skill\Skills;

use App\CaseConverter;
use App\Character\Character;
use App\Enum\SkillTagEnum;

abstract class AbstractSkill
{
    protected const ORDER = 1000;
    protected const TAGS = [
        SkillTagEnum::PASSIVE
    ];

    public function __construct(
        protected readonly Character $character,
        protected readonly string $name
    ) {
    }

    public function getName(): string
    {
        return \str_replace('feat ', '', $this->name);
    }

    public function getUsageCount(): int
    {
        return 0;
    }

    public function getTags(): array
    {
        return $this::TAGS;
    }

    public function getOrder(): int
    {
        return $this::ORDER;
    }

    public function getTemplate(): string
    {
        return 'skill_templates/' . CaseConverter::normalToSnake($this->name) . '.html.twig';
    }

    abstract public function getContext(): array;
}
