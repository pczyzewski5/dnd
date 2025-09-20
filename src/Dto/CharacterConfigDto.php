<?php

declare(strict_types=1);

namespace App\Dto;

use App\Dto\Validator as CustomAssert;
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
    public readonly mixed $levelConfigs;

    #[Assert\Valid]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'array')]
    #[CustomAssert\AbilityConfigs]
    public readonly mixed $abilityConfigs;

    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $meta;

    public function __construct(
        mixed $characterName,
        mixed $playerName,
        mixed $campaignName,
        mixed $origin,
        mixed $race,
        mixed $alignment,
        mixed $levelConfigs,
        mixed $abilityConfigs,
        mixed $meta
    ) {
        $this->characterName = $characterName;
        $this->playerName = $playerName;
        $this->campaignName = $campaignName;
        $this->origin = $origin;
        $this->race = $race;
        $this->alignment = $alignment;
        $this->levelConfigs = $levelConfigs;
        $this->abilityConfigs = $abilityConfigs;
        $this->meta = $meta;
    }
}
