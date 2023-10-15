<?php

namespace DND\Skill\Skills;

use App\CaseConverter;
use DND\Character\Character;

abstract class AbstractSkill
{
    public const ORDER = 1000;
    public const TYPE = 'passive';

    protected Character $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function getTemplate(): string
    {
        return 'skill_templates/' . CaseConverter::upperCamelToSnake((new \ReflectionClass($this))->getShortName()) . '.html.twig';
    }

    abstract public function getContext(): array;
}
