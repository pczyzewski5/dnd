<?php

namespace DND\Skill\Skills;

use App\CaseConverter;
use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;

abstract class AbstractSkill
{
    protected const TAGS = [
        SkillTagEnum::PASSIVE
    ];
    protected const ORDER = 1000;

    protected Character $character;
    protected string $name;
    protected int $grantLevel;

    public function __construct(Character $character, string $skillName, int $grantLevel)
    {
        $this->character = $character;
        $this->name = $skillName;
        $this->grantLevel = $grantLevel;
    }

    public function getName(): string
    {
        return \str_replace('feat ', '', $this->name);
    }

    public function getGrantLevel(): int
    {
        return $this->grantLevel;
    }

    public function getUsageCount(): int
    {
        return 0;
    }

    public function getTags(): array
    {
        return self::TAGS;
    }

    public function getOrder(): int
    {
        return self::ORDER;
    }

    public function getTemplate(): string
    {
        return 'skill_templates/' . CaseConverter::normalToSnake($this->name) . '.html.twig';
    }

    abstract public function getContext(): array;
}
