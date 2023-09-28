<?php

namespace DND\CharacterCard\SectionBuilder;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
        ];

        return $this->twig->render(
            'character_card/sections/skills.html.twig',
            $context
        );
    }
}