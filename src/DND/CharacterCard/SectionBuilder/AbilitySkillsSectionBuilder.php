<?php

namespace DND\CharacterCard\SectionBuilder;

class AbilitySkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'abilitySkills' => $this->character->getSkills(),
        ];

        return $this->twig->render(
            'character_card/sections/ability_skills.html.twig',
            $context
        );
    }
}