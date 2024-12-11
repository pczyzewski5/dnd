<?php

namespace App\CharacterCard\SectionBuilder;

class DealtDmgBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [];

        return $this->twig->render(
            'character_card/sections/dealt_dmg.html.twig',
            $context
        );
    }
}