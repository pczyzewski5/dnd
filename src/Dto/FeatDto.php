<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class FeatDto
{
    #[Assert\NotBlank]
    #[Assert\Type(type: 'string')]
    public readonly mixed $name;

    #[Assert\NotBlank]
    #[Assert\Choice(
        choices: [
            'race',
            'level',
        ]
    )]
    public readonly mixed $source;

    public function __construct(
        mixed $name,
        mixed $source,
    ) {
        $this->name = $name;
        $this->source = $source;
    }
}
