<?php

namespace DND\CharacterCard\SectionBuilder;

class HpSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [];

        return $this->twig->render(
            'character_card/sections/hp.html.twig',
            $context
        );
    }
}