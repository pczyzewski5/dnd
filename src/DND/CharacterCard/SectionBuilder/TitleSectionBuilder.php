<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(Character $character): string
    {
        $context =  [
            'character' => $character,
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}