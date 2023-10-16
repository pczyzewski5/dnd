<?php

namespace DND\CharacterCard\SectionBuilder;

class AttacksTricksSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'attackCount' => $this->character->getAttackCount(),
        ];

        return $this->twig->render(
            'character_card/sections/attacks_tricks.html.twig',
            $context
        );
    }
}