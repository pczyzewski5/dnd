<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class AbilitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(Character $character): string
    {
        $context =  [
            'abilities' => $character->getAbilities(),
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/abilities.html.twig',
            $context
        );
    }
}