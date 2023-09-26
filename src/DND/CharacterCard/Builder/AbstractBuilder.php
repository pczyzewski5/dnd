<?php

namespace DND\CharacterCard\Builder;

use Twig\Environment;

abstract class AbstractBuilder
{
    protected Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    abstract public function build(): string;
}