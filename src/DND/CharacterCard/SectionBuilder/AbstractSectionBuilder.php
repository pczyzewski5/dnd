<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;
use Twig\Environment;

abstract class AbstractSectionBuilder
{
    protected Environment $twig;
    protected string $stylesPath;

    public function __construct(Environment $twig, string $stylesPath)
    {
        $this->twig = $twig;
        $this->stylesPath = $stylesPath;
    }

    abstract public function build(Character $character): string;
}