<?php

namespace DND\CharacterCard\SectionBuilder;

class PassivePerceptionIntuitionSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'passive_perception' => 12,
            'passive_intuition' => 10,
        ];

        return $this->twig->render(
            'character_card/sections/passive_perception_intuition.html.twig',
            $context
        );
    }
}