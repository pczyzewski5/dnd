<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Domain\PassiveInsightCalculator;
use DND\Domain\PassivePerceptionCalculator;

class PassivePerceptionIntuitionSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $abilities = $this->character->getAbilities();
        $proficiencies = $this->character->getProficiencies();
        $proficiencyBonus = $this->character->getProficiencyBonus();

        $context =  [
            'passive_perception' => PassivePerceptionCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
            'passive_intuition' => PassiveInsightCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
        ];

        return $this->twig->render(
            'character_card/sections/passive_perception_intuition.html.twig',
            $context
        );
    }
}