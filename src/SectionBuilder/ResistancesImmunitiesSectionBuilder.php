<?php

declare(strict_types=1);

namespace App\SectionBuilder;

class ResistancesImmunitiesSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        return $this->twig->render(
            'character_card/sections/resistances_immunities.html.twig', [
            'resistances' => \implode(', ', []),
            'immunities' => []
        ]);
    }
}