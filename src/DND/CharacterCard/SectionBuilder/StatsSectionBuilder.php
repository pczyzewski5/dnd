<?php

namespace DND\CharacterCard\SectionBuilder;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
            'proficiencyBonus' => 3,
            'acWithoutArmor' => 15,
            'hp' => 77,
            'initiative' => 2,
            'nightvision' => 0,
            'speed' => 8,
        ];

        return $this->twig->render(
            'character_card/sections/stats.html.twig',
            $context
        );
    }
}