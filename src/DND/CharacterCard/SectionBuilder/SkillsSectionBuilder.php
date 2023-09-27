<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class SkillsSectionBuilder extends AbstractSectionBuilder
{
    public function build(Character $character): string
    {
        $context =  [
            'skills' => $character->getSkills(),
            'styles' => \file_get_contents($this->stylesPath)
        ];

        return $this->twig->render(
            'character_card/sections/skills.html.twig',
            $context
        );
    }
}