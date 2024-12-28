<?php

namespace App\SectionBuilder;

class StatsSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context = [
            'proficiencyBonus' => $this->character->proficiencyBonus,
            'acWithoutArmor' => $this->character->armorClass,
            'hp' => $this->character->hitPoints,
            'initiative' => $this->character->initiative,
            'darkvision' => $this->character->darkvision,
            'speed' => $this->character->speed,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/stats.html.twig',
            $context
        );
    }
}