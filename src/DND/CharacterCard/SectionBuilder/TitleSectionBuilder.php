<?php

namespace DND\CharacterCard\SectionBuilder;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'character' => $this->character,
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}