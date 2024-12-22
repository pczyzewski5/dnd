<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class AbilitiesDto
{
    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $str;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $dex;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $con;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $int;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $wis;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[Assert\Range(min: 1, max: 20)]
    public readonly mixed $cha;

    public function __construct(
        mixed $str,
        mixed $dex,
        mixed $con,
        mixed $int,
        mixed $wis,
        mixed $cha
    ) {
        $this->str = $str;
        $this->dex = $dex;
        $this->con = $con;
        $this->int = $int;
        $this->wis = $wis;
        $this->cha = $cha;
    }
}
