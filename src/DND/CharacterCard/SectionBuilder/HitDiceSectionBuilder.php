<?php

namespace DND\CharacterCard\SectionBuilder;

class HitDiceSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'classHitDiceCount' => 8,
            'classHitDiceType' => 'D12',
            'subclassHitDiceCount' => 1,
            'subclassHitDiceType' => 'D8'
        ];

        return $this->twig->render(
            'character_card/sections/hit_dice.html.twig',
            $context
        );
    }
}