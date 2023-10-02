<?php

namespace DND\CharacterCard\SectionBuilder;

use DND\Character\Character;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'class' => $this->getClass($this->character),
            'level' => $this->character->getLevels()->getLevel(),
            'origin' => $this->character->getOrigin()->getValue(),
            'characterName' => $this->character->getCharacterName(),
            'playerName' => $this->character->getPlayerName(),
            'race' => $this->character->getRace()->getName(),
            'alignment' => $this->character->getAlignment()->getValue(),
            'campaign' => $this->character->getCampaignName(),
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }

    private function getClass(Character $character): string
    {
        $classes = \array_map('ucfirst', $this->character->getLevels()->getCharacterClasses());

        return \implode('-', $classes);
    }
}