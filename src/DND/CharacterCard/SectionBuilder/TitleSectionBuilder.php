<?php

namespace DND\CharacterCard\SectionBuilder;

class TitleSectionBuilder extends AbstractSectionBuilder
{
    public function build(): string
    {
        $context =  [
            'class' => $this->character->getLevels()->getCharacterClass()->getValue(),
            'level' => $this->character->getLevels()->getLevel(),
            'origin' => $this->character->getOrigin()->getValue(),
            'characterName' => $this->character->getCharacterName(),
            'playerName' => $this->character->getPlayerName(),
            'race' => $this->character->getRace()->getValue(),
            'alignment' => $this->character->getAlignment()->getValue(),
            'campaign' => $this->character->getCampaignName(),
        ];

        return $this->twig->render(
            'character_card/sections/title.html.twig',
            $context
        );
    }
}