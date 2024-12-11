<?php

namespace App\CharacterCard\SectionBuilder;

use App\Enum\AbilityEnum;
use App\Enum\AbilitySkillEnum;

class ProficienciesLanguagesSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $proficienciesToRender = [];

        foreach ($this->character->getProficiencies()->getAll() as $proficiency) {
            if (AbilityEnum::isValid($proficiency) || AbilitySkillEnum::isValid($proficiency)) {
                continue;
            }
            $proficienciesToRender[] = $proficiency;
        }

        $context = [
            'proficiencies' => \implode(', ', $proficienciesToRender),
            'languages' => \implode(', ', $this->character->getLanguages()),
        ];

        return $this->twig->render(
            'character_card/sections/proficiencies_languages.html.twig',
            $context
        );
    }
}