<?php

namespace App\CharacterCard\SectionBuilder;

class AbilitySkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'abilitySkills' => $this->character->getAbilitySkills(),
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/ability_skills.html.twig',
            $context
        );
    }
}