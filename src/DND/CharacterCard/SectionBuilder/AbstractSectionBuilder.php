<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;
use Twig\Environment;

abstract class AbstractSectionBuilder
{
    protected Character $character;
    protected Environment $twig;

    public function __construct(Character $character, Environment $twig)
    {
        $this->character = $character;
        $this->twig = $twig;
    }

    abstract public function build(): string;
}