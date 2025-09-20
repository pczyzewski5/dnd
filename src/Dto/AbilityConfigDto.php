<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AbilityConfigDto
{
    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: [
            'str',
            'dex',
            'con',
            'int',
            'wis',
            'cha'
        ]
    )]
    public readonly mixed $ability;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    public readonly mixed $value;

    public function __construct(
        mixed $ability,
        mixed $value,
    ) {
        $this->ability = $ability;
        $this->value = $value;
    }
}
