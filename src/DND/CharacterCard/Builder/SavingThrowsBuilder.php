<?php

namespace DND\CharacterCard\Builder;

use DND\Domain\SavingThrows\SavingThrows;

class SavingThrowsBuilder extends AbstractBuilder
{
    private SavingThrows $savingThrows;

    public function setSavingThrows(SavingThrows $savingThrows): void
    {
        $this->savingThrows = $savingThrows;
    }

    public function build(): string
    {
        $context =  [
            'savingThrows' => $this->savingThrows,
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/saving_throws.html.twig',
            $context
        );
    }
}