<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class SavingThrowsSectionBuilder extends AbstractSectionBuilder
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