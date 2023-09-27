<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(Character $character): string
    {
        $context = [
            'styles' => \file_get_contents($this->stylesPath)
        ];

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