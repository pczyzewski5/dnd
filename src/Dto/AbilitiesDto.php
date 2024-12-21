<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AbilitiesDto
{
    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $str;

    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $dex;

    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $con;

    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $int;

    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $wis;

    #[Assert\NotNull]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public ?int $cha;
}
