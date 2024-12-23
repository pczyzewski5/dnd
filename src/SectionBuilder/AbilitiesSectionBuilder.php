<?php

namespace App\SectionBuilder;

class AbilitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'abilities' => $this->character->abilities,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/new_sections/abilities.html.twig',
            $context
        );
    }
}