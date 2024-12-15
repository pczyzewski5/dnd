<?php

namespace App\CharacterCard\SectionBuilder;

use App\Calculator\PassiveInsightCalculator;
use App\Calculator\PassivePerceptionCalculator;

class PassivePerceptionIntuitionSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $abilities = $this->character->getAbilities();
        $proficiencies = $this->character->getProficiencies();
        $proficiencyBonus = $this->character->getProficiencyBonus();

        $context =  [
            'passive_perception' => PassivePerceptionCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
            'passive_intuition' => PassiveInsightCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/passive_perception_intuition.html.twig',
            $context
        );
    }
}