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
            'initiative' => 99,
            'nightvision' => 99,
            'speed' => 99,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/new_sections/stats.html.twig',
            $context
        );
    }
}