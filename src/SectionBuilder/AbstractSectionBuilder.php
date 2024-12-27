<?php

namespace App\SectionBuilder;

use App\Character\Character;
use Twig\Environment;

abstract class AbstractSectionBuilder
{
    public function __construct(
        protected readonly Character $character,
        protected readonly Environment $twig
    ) {
    }

    abstract public function build(bool $printMode = false): string;
}