<?php

declare(strict_types=1);

namespace App\SectionBuilder;

use function key;
use function reset;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $simpleLevels = $this->character->simpleLevels;

        $context = [
            'characterName' => $this->character->characterName,
            'className' => key($simpleLevels),
            'level' => reset($simpleLevels),
            'origin' => $this->character->origin,
            'playerName' => $this->character->playerName,
            'race' => $this->character->race,
            'alignment' => $this->character->alignment,
            'campaign' => $this->character->campaignName,
        ];

        return $this->twig->render(
            'character_card/new_sections/title.html.twig',
            $context
        );
    }
}