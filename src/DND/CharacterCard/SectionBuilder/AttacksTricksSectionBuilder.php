<?php

namespace DND\CharacterCard\SectionBuilder;

class AttacksTricksSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'abilitySkills' => $this->character->getSkills(),
        ];

        return $this->twig->render(
            'character_card/sections/attacks_tricks.html.twig',
            $context
        );
    }
}