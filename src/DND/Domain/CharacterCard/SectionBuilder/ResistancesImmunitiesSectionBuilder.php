<?php

namespace DND\Domain\CharacterCard\SectionBuilder;

class ResistancesImmunitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
            'resistances' => \implode(', ', $this->character->getResistances()),
            'immunities' => \implode(', ', $this->character->getImmunities())
        ];

        return $this->twig->render(
            'character_card/sections/resistances_immunities.html.twig',
            $context
        );
    }
}