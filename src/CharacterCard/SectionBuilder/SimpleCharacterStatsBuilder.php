<?php

namespace App\CharacterCard\SectionBuilder;

use App\Calculator\PassiveInsightCalculator;
use App\Calculator\PassivePerceptionCalculator;

class SimpleCharacterStatsBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $abilities = $this->character->getAbilities();
        $proficiencies = $this->character->getProficiencies();
        $proficiencyBonus = $this->character->getProficiencyBonus();

        $context =  [
            'abilities' => $abilities,
            'abilitySkills' => $this->character->getAbilitySkills(),
            'savingThrows' => $this->character->getSavingThrows(),
            'proficiencyBonus' => $proficiencyBonus,
            'acWithoutArmor' => $this->character->getArmorClassWithoutArmor(),
            'hp' => $this->character->getHitPoints(),
            'initiative' => $this->character->getInitiative(),
            'nightvision' => $this->character->getNightvision(),
            'speed' => $this->character->getSpeed(),
            'passive_perception' => PassivePerceptionCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
            'passive_intuition' => PassiveInsightCalculator::calculate($abilities, $proficiencies, $proficiencyBonus),
        ];

        return $this->twig->render(
            'character_card/sections/simple_character_stats.html.twig',
            $context
        );
    }
}