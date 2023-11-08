<?php

namespace DND\Domain\CharacterCard\SectionBuilder;

class SavingThrowsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'savingThrows' => $this->character->getSavingThrows(),
        ];

        return $this->twig->render(
            'character_card/sections/saving_throws.html.twig',
            $context
        );
    }
}