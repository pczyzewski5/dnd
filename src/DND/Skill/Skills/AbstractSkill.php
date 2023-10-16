<?php

namespace DND\Skill\Skills;

use App\CaseConverter;
use DND\Character\Character;
use DND\Domain\Enum\SkillTagEnum;
use DND\Skill\Skill;

abstract class AbstractSkill
{
    public const ORDER = 1000;

    protected Character $character;
    protected Skill $skill;
    protected int $count = 0;
    protected array $tags = [
        SkillTagEnum::PASSIVE
    ];

    public function __construct(Character $character, Skill $skill)
    {
        $this->character = $character;
        $this->skill = $skill;
    }

    public function getName(): string
    {
        return $this->skill->getName();
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function hasTag(SkillTagEnum $skillTagEnum): bool
    {
        return \in_array($skillTagEnum->getValue(), $this->tags);
    }

    public function getTemplate(): string
    {
        return 'skill_templates/' . CaseConverter::normalToSnake($this->skill->getName()) . '.html.twig';
    }

    abstract public function getContext(): array;
}
