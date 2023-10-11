<?php

namespace DND\CharacterCard\SectionBuilder;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $skills = [];

        foreach ($this->character->getSkills() as $skill) {
            $skills[] = $this->twig->render(
                $skill->getTemplate(),
                $skill->getContext()
            );
        }

        $context = [
            'skills' => $skills
        ];

        return $this->twig->render(
            'character_card/sections/skills.html.twig',
            $context
        );
    }
}