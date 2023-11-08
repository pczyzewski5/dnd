<?php

namespace DND\Domain\CharacterCard\SectionBuilder;

use DND\Domain\Enum\AbilityEnum;
use DND\Domain\Enum\AbilitySkillEnum;

class ProficienciesLanguagesSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
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