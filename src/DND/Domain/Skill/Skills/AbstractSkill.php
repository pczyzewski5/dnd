<?php

declare(strict_types=1);

namespace DND\Domain\Skill\Skills;

use App\CaseConverter;
use DND\Domain\Character\Character;
use DND\Domain\Enum\SkillTagEnum;

abstract class AbstractSkill
{
    protected const ORDER = 1000;
    protected const TAGS = [
        SkillTagEnum::PASSIVE
    ];

    protected Character $character;
    protected string $name;

    public function __construct(Character $character, string $name)
    {
        $this->character = $character;
        $this->name = $name;
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
