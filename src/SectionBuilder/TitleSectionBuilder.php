<?php

declare(strict_types=1);

namespace App\SectionBuilder;

use function implode;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(bool $printMode = false): string
    {
        $classAndLevel = [];

        foreach ($this->character->simpleLevels as $characterClass => $level) {
            $classAndLevel[] = $characterClass . ' ' . $level;
        }

        $context = [
            'characterName' => $this->character->characterName,
            'classAndLevel' => implode(' | ', $classAndLevel),
            'origin' => $this->character->origin,
            'playerName' => $this->character->playerName,
            'race' => $this->character->race,
            'alignment' => $this->character->alignment,
            'campaign' => $this->character->campaignName,
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}