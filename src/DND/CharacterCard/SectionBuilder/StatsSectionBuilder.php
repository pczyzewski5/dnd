<?php

namespace DND\CharacterCard\SectionBuilder;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context = [
            'proficiencyBonus' => $this->character->getProficiencyBonus(),
            'acWithoutArmor' => $this->character->getArmorClassWithoutArmor(),
            'hp' => 77,
            'initiative' => $this->character->getInitiative(),
            'nightvision' => $this->character->getNightvision(),
            'speed' => $this->character->getSpeed(),
        ];

        return $this->twig->render(
            'character_card/sections/stats.html.twig',
            $context
        );
    }
}