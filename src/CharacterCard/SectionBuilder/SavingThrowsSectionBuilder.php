<?php

namespace App\CharacterCard\SectionBuilder;

class SavingThrowsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'savingThrows' => $this->character->getSavingThrows(),
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/saving_throws.html.twig',
            $context
        );
    }
}