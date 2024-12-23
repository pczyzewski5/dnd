<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class CharacterConfigDto
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $characterName;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $playerName;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $campaignName;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $origin;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $race;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $alignment;

    #[Assert\Valid]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    public readonly mixed $levelConfigDtos;

    #[Assert\Valid]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    public readonly mixed $abilityConfigDtos;

    public function __construct(
        mixed $characterName,
        mixed $playerName,
        mixed $campaignName,
        mixed $origin,
        mixed $race,
        mixed $alignment,
        mixed $levelConfigDtos,
        mixed $abilityConfigDtos,
    ) {
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->campaignName = $campaignName;
        $this->origin = $origin;
        $this->race = $race;
        $this->alignment = $alignment;
        $this->levelConfigDtos = $levelConfigDtos;
        $this->abilityConfigDtos = $abilityConfigDtos;
    }
}
