<?php

namespace DND\CharacterCard\Builder;

use DND\Character\Character;

class SavingThrowsBuilder extends AbstractBuilder
{
    public function build(Character $character): string
    {
        $context =  [
            'savingThrows' => $character->getSavingThrows(),
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/saving_throws.html.twig',
            $context
        );
    }
}