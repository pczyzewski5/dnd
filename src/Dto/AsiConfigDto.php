<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AsiConfigDto extends AbilityConfigDto
{
    #[Assert\NotBlank]
    public readonly mixed $source;

    public function __construct(
        mixed $ability,
        mixed $value,
        mixed $source
    ) {
        $this->source = $source;

        parent::__construct($ability, $value);
    }
}
