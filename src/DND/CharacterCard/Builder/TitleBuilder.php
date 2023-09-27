<?php

namespace DND\CharacterCard\Builder;

use DND\Character\Character;

class TitleBuilder extends AbstractBuilder
{
    private Character $character;

    public function setCharacter(Character $character): void
    {
        $this->character = $character;
    }

    public function build(): string
    {
        $context =  [
            'character' => $this->character,
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}