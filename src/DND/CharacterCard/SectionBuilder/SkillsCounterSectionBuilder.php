<?php

namespace DND\CharacterCard\SectionBuilder;

class SkillsCounterSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'abilitySkills' => $this->character->getSkills(),
        ];

        return $this->twig->render(
            'character_card/sections/skills_counter.html.twig',
            $context
        );
    }
}