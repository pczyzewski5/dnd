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
    public readonly mixed $characterClass;

    #[Assert\Valid]
    #[Assert\Type(type: FeatDto::class)]
    public readonly mixed $feat;

    #[Assert\Type(type: 'array')]
    public readonly mixed $proficiencies;

    #[Assert\Type(type: 'array')]
    public readonly mixed $skills;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $asi;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $expertises;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $languages;

    #[Assert\Valid]
    #[Assert\Type(type: 'array')]
    public readonly mixed $cantrips;

    public function __construct(
        mixed $level,
        mixed $characterClass,
        mixed $feat = null,
        mixed $proficiencies = null,
        mixed $skills = null,
        mixed $asi = null,
        mixed $expertises = null,
        mixed $languages = null,
        mixed $cantrips = null,
    ) {
        $this->level = $level;
        $this->characterClass = $characterClass;
        $this->feat = $feat;
        $this->proficiencies = $proficiencies ?? [];
        $this->skills = $skills ?? [];
        $this->asi = $asi ?? [];
        $this->expertises = $expertises ?? [];
        $this->languages = $languages ?? [];
        $this->cantrips = $cantrips ?? [];
    }
}
