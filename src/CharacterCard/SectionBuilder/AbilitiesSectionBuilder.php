<?php

namespace App\CharacterCard\SectionBuilder;

class AbilitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'abilities' => $this->character->getAbilities(),
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/abilities.html.twig',
            $context
        );
    }
}