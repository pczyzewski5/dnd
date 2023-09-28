<?php

namespace DND\CharacterCard\SectionBuilder;

class ProficienciesLanguagesSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
            'proficiencies' => 'fire, lightning.',
            'languages' => 'poison, mental.',
        ];

        return $this->twig->render(
            'character_card/sections/proficiencies_languages.html.twig',
            $context
        );
    }
}