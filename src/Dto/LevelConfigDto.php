<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class LevelConfigDto
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    public readonly mixed $level;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $class;

    #[Assert\Type(type: 'array')]
    public readonly mixed $proficiencies;

    #[Assert\Type(type: 'array')]
    public readonly mixed $skills;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $asi;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $languages;

    public function __construct(
        mixed $level,
        mixed $class,
        mixed $proficiencies = null,
        mixed $skills = null,
        mixed $asi = null,
        mixed $languages = null
    ) {
        $this->level = $level;
        $this->class = $class;
        $this->proficiencies = $proficiencies ?? [];
        $this->skills = $skills ?? [];
        $this->asi = $asi ?? [];
        $this->languages = $languages ?? [];
    }
}
