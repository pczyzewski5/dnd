<?php

namespace DND\CharacterCard\SectionBuilder;

class AbilitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'abilities' => $this->character->getAbilities(),
        ];

        return $this->twig->render(
            'character_card/sections/abilities.html.twig',
            $context
        );
    }
}