<?php

namespace DND\CharacterCard\Builder;

use DND\Character\Character;

class TitleBuilder extends AbstractBuilder
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