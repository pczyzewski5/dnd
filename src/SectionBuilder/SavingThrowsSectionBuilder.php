<?php

namespace App\SectionBuilder;

use function var_dump;

class SavingThrowsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'savingThrows' => $this->character->savingThrows,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/saving_throws.html.twig',
            $context
        );
    }
}