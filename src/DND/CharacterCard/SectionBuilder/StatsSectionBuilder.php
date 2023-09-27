<?php

namespace DND\CharacterCard\SectionBuilder;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context['stats'] = [
            'hp' => 77,
            'proficiency bonus' => 3,
            'ac without armor' => 15,
            'initiative' => 2,
            'nightvision' => 'n/a',
            'speed' => '8 hex',
        ];

        return $this->twig->render(
            'character_card/sections/stats.html.twig',
            $context
        );
    }
}