<?php

namespace App\SectionBuilder;

class ProficienciesLanguagesSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context = [
            'proficiencies' => $this->character->proficiencies,
            'languages' => $this->character->languages
        ];

        return $this->twig->render(
            'character_card/new_sections/proficiencies_languages.html.twig',
            $context
        );
    }
}