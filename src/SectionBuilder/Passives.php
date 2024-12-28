<?php

namespace App\SectionBuilder;

use App\Calculator\PassiveInsightCalculator;
use App\Calculator\PassivePerceptionCalculator;

class Passives extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $context =  [
            'passivePerception' => $this->character->passivePerception,
            'passiveInsight' => $this->character->passiveInsight,
            'printMode' => $printMode,
        ];

        return $this->twig->render(
            'character_card/sections/passives.html.twig',
            $context
        );
    }
}