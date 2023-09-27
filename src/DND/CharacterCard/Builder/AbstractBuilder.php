<?php

namespace DND\CharacterCard\Builder;

use Twig\Environment;

abstract class AbstractBuilder
{
    protected Environment $twig;
    protected string $stylesPath;

    public function __construct(Environment $twig, string $stylesPath)
    {
        $this->twig = $twig;
        $this->stylesPath = $stylesPath;
    }

    abstract public function build(): string;
}