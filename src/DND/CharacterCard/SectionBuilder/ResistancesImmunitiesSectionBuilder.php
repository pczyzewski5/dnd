<?php

namespace DND\CharacterCard\SectionBuilder;

class ResistancesImmunitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
            'resistances' => 'fire, lightning.',
            'immunities' => 'poison, mental.',
        ];

        return $this->twig->render(
            'character_card/sections/resistances_immunities.html.twig',
            $context
        );
    }
}