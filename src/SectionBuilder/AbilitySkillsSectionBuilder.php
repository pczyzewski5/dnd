<?php

namespace App\SectionBuilder;

use function var_dump;

class AbilitySkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'abilitySkills' => $this->character->abilitySkills,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/ability_skills.html.twig',
            $context
        );
    }
}