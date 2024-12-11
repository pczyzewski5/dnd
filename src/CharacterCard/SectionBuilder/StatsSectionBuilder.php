<?php

namespace App\CharacterCard\SectionBuilder;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context = [
            'proficiencyBonus' => $this->character->getProficiencyBonus(),
            'acWithoutArmor' => $this->character->getArmorClassWithoutArmor(),
            'hp' => $this->character->getHitPoints(),
            'initiative' => $this->character->getInitiative(),
            'nightvision' => $this->character->getNightvision(),
            'speed' => $this->character->getSpeed(),
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/stats.html.twig',
            $context
        );
    }
}