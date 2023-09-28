<?php

namespace DND\CharacterCard\SectionBuilder;

class DealtDmgBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [];

        return $this->twig->render(
            'character_card/sections/dealt_dmg.html.twig',
            $context
        );
    }
}